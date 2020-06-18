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
use function is_int;

class Form extends BaseForm
{

    public const IMAGE_TYPE_PATH = "path";
    public const IMAGE_TYPE_URL = "url";

    public function __construct(Closure $onSubmit, ?Closure $onClose = null)
    {
        parent::__construct($onSubmit, $onClose);
        $this->setType(self::FORM_TYPE);
        $this->setMessage("");
    }

    /**
     * Sets the message before all the buttons
     *
     * @param string $message
     * @return Form
     */
    public final function setMessage(string $message): self
    {
        $this->data["content"] = $message;

        return $this;
    }

    public final function getMessage(): string
    {
        return $this->data["content"];
    }

    /**
     * Adds a button without images.
     *
     * @param string $text
     * @param string|null $label
     * @return Form
     */
    public final function addClassicButton(string $text, ?string $label = null): self
    {
        return $this->addButton($text, null, "", $label);
    }

    protected final function addButton(string $text, ?string $imageType = null, string $imagePath = "", ?string $label = null): self
    {
        $data["text"] = $text;
        if ($imageType !== null) {
            $data["image"]["type"] = $imageType;
            $data["image"]["data"] = $imagePath;
        }

        $this->data["buttons"][] = $data;

        return $this->addDataLabel($label);
    }

    /**
     * Adds a button with an image taken from the web.
     *
     * @param string $text
     * @param string $url
     * @param string|null $label
     * @return Form
     */
    public final function addWebImageButton(string $text, string $url, ?string $label = null): self
    {
        return $this->addButton($text, self::IMAGE_TYPE_URL, $url, $label);
    }

    /**
     * Adds a button with a local Minecraft image.
     *
     * @param string $text
     * @param string $imagePath
     * @param string|null $label
     * @return Form
     */
    public final function addLocalImageButton(string $text, string $imagePath, ?string $label = null): self
    {
        return $this->addButton($text, self::IMAGE_TYPE_PATH, $imagePath, $label);
    }

    protected function processLabels(&$data): void
    {
        if (is_int($data) && isset($this->dataLabels[$data])) {
            $data = $this->dataLabels[$data];
        }
    }

}