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
use InvalidArgumentException;

class ModalForm extends BaseForm{

	public function __construct(Closure $closure){
		parent::__construct($closure);
		$this->setType(self::MODAL_FORM_TYPE);
		$this->setButton(1, "")
			->setButton(2, "")
			->setMessage("");
	}

	public final function setMessage(string $message) : self{
		$this->data["content"] = $message;

		return $this;
	}

	public final function getMessage() : string{
		return $this->data["content"];
	}

	/**
	 * @param int    $button It must be 1 or 2
	 * @param string $text The button text
	 *
	 * @return ModalForm
	 */
	public final function setButton(int $button, string $text) : self{
		if($button < 1 || $button > 2){
			throw new InvalidArgumentException("The button value must be 1 or 2.");
		}
		$this->data["button{$button}"] = $text;

		return $this;
	}

	public final function getButton(int $button) : string{
		if($button < 1 || $button > 2){
			throw new InvalidArgumentException("The button value must be 1 or 2.");
		}

		return $this->data["button{$button}"];
	}
}