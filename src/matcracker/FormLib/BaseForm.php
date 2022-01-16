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
use pocketmine\player\Player;
use pocketmine\utils\Utils;
use function count;

abstract class BaseForm implements Form
{
    public const FORM_TYPE = "form";
    public const MODAL_FORM_TYPE = "modal";
    public const CUSTOM_FORM_TYPE = "custom_form";

    protected array $data = [];
    /** @var string[] */
    protected array $dataLabels = [];

	/**
	 * BaseForm constructor.
	 *
	 * @param Closure      $onSubmit Called when the form is submitted.
	 * @param Closure|null $onClose Called when the form is closed.
	 */
    public function __construct(private Closure $onSubmit, private ?Closure $onClose = null)
    {
        Utils::validateCallableSignature(function (Player $player, $data) {
        }, $onSubmit);
        if ($onClose !== null) {
            Utils::validateCallableSignature(function (Player $player) {
            }, $onClose);
        }
        $this->setTitle("");
    }

    /**
     * It sets the title form.
     *
     * @param string $title
     * @return BaseForm
     */
    public final function setTitle(string $title): self
    {
        $this->data["title"] = $title;

        return $this;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data !== null) {
            $this->processLabels($data);

            ($this->onSubmit)($player, $data);
        } else {
            if ($this->onClose !== null) {
                ($this->onClose)($player);
            }
        }
    }

    protected abstract function processLabels(mixed &$data): void;

    public final function jsonSerialize()
    {
        return $this->data;
    }

    public final function getTitle(): string
    {
        return $this->data["title"];
    }

    public final function getType(): string
    {
        return $this->data["type"];
    }

    protected final function addDataLabel(?string $label): self
    {
        $this->dataLabels[] = $label ?? count($this->dataLabels);
        return $this;
    }

    /**
     * Sets the form type.
     *
     * @param string $type see BaseForm constants.
     * @return BaseForm
     */
    protected final function setType(string $type): self
    {
        $this->data["type"] = $type;

        return $this;
    }
}