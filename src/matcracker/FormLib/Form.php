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

class Form extends BaseForm{

	public const IMAGE_TYPE_PATH = 0;
	public const IMAGE_TYPE_URL = 1;

	public function __construct(Closure $closure){
		parent::__construct($closure);
		$this->setType(self::FORM_TYPE);
		$this->setMessage("");
	}

	public final function setMessage(string $message) : self{
		$this->data["content"] = $message;

		return $this;
	}

	public final function getMessage() : string{
		return $this->data["content"];
	}

	protected final function addButton(string $text, ?int $imageType = null, string $imagePath = "") : self{
		$data["text"] = $text;
		if($imageType !== null){
			$data["image"]["type"] = $imageType === self::IMAGE_TYPE_PATH ? "path" : "url";
			$data["image"]["data"] = $imagePath;
		}

		$this->data["buttons"][] = $data;

		return $this;
	}

	public final function addClassicButton(string $text) : self{
		return $this->addButton($text);
	}

	public final function addWebImageButton(string $text, string $url) : self{
		return $this->addButton($text, self::IMAGE_TYPE_URL, $url);
	}

	public final function addLocalImageButton(string $text, string $imagePath) : self{
		return $this->addButton($text, self::IMAGE_TYPE_PATH, $imagePath);
	}

}