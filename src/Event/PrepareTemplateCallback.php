<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Event;

use Contao\LayoutModel;

class PrepareTemplateCallback
{
    /**
     * @var string
     */
    protected $templateName;
    /**
     * @var string
     */
    protected $customTemplateName;
    /**
     * @var string
     */
    protected $templatePath;
    /**
     * @var array
     */
    protected $data;
    /**
     * @var LayoutModel
     */
    protected $layoutModel;

    /**
     * PrepareTemplateCallback constructor.
     */
    public function __construct(string $templateName, string $customTemplateName, string $templatePath, array $data, LayoutModel $layoutModel)
    {
        $this->templateName = $templateName;
        $this->customTemplateName = $customTemplateName;
        $this->templatePath = $templatePath;
        $this->data = $data;
        $this->layoutModel = $layoutModel;
    }

    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    public function getCustomTemplateName(): string
    {
        return $this->customTemplateName;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setCustomTemplateName(string $customTemplateName): void
    {
        $this->customTemplateName = $customTemplateName;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getLayoutModel(): LayoutModel
    {
        return $this->layoutModel;
    }
}
