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
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\Utils;

abstract class BaseForm implements Form{

	public const FORM_TYPE = "form";
	public const MODAL_FORM_TYPE = "modal";
	public const CUSTOM_FORM_TYPE = "custom_form";

	private $closure;
	protected $data;

	public function __construct(Closure $closure){
		Utils::validateCallableSignature(function(Player $player, $data){
		}, $closure);
		$this->closure = $closure;
		$this->setTitle("");
	}

	public function handleResponse(Player $player, $data) : void{
		($this->closure)($player, $data);
	}

	public final function jsonSerialize(){
		return $this->data;
	}

	public final function setTitle(string $title) : self{
		$this->data["title"] = $title;

		return $this;
	}

	public final function getTitle() : string{
		return $this->data["title"];
	}

	protected final function setType(string $type) : self{
		$this->data["type"] = $type;

		return $this;
	}

	public final function getType() : string{
		return $this->data["type"];
	}
}