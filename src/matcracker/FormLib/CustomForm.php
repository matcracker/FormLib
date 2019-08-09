<?php

/*
 *
 *  88888888b                              dP        oo dP
 *  88                                     88           88
 *  a88aaaa    .d8888b. 88d888b. 88d8b.d8b. 88        dP 88d888b.
 *  88        88'  `88 88'  `88 88'`88'`88 88        88 88'  `88
 *  88        88.  .88 88       88  88  88 88        88 88.  .88
 *  dP        `88888P' dP       dP  dP  dP 88888888P dP 88Y8888'
 *
 * Copyright (C) 2019
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author matcracker
 * @link https://www.github.com/matcracker/FormLib
 *
*/

declare(strict_types=1);

namespace matcracker\FormLib;

use Closure;

class CustomForm extends BaseForm{

	public const DROPDOWN = "dropdown";
	public const INPUT = "input";
	public const LABEL = "label";
	public const SLIDER = "slider";
	public const STEP_SLIDER = "step_slider";
	public const TOGGLE = "toggle";

	public function __construct(Closure $closure){
		parent::__construct($closure);
		$this->setType(self::CUSTOM_FORM_TYPE);
		$this->data["content"] = [];
	}

	public final function addDropdown(string $text, array $options, ?int $defaultIndexOption = null) : self{
		return $this->addContent(self::DROPDOWN, $text, [
			"options" => $options,
			"default" => $defaultIndexOption
		]);
	}

	public final function addInput(string $text, string $placeHolder = "", ?string $default = null) : self{
		return $this->addContent(self::INPUT, $text, [
			"placeholder" => $placeHolder,
			"default" => $default
		]);
	}

	public final function addLabel(string $text) : self{
		return $this->addContent(self::LABEL, $text, []);
	}

	public final function addSlider(string $text, int $min, int $max, ?int $step = null, ?int $default = null) : self{
		return $this->addContent(self::SLIDER, $text, [
			"min" => $min,
			"max" => $max,
			"step" => $step,
			"default" => $default
		]);
	}

	public final function addStepSlider(string $text, array $steps, ?int $default = null) : self{
		return $this->addContent(self::STEP_SLIDER, $text, [
			"steps" => $steps,
			"default" => $default
		]);
	}

	public final function addToggle(string $text, ?bool $default = null) : self{
		return $this->addContent(self::TOGGLE, $text, [
			"default" => $default
		]);
	}

	protected final function addContent(string $type, string $text, array $contentData) : self{
		$this->data["content"][] = array_merge(
			[
				"type" => $type,
				"text" => $text
			],
			array_filter($contentData) //Remove null fields
		);

		return $this;
	}

}