<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Event;

use Contao\LayoutModel;

class BeforeRenderCallback
{
    protected $twigTemplateName;
    protected $twigTemplateContext;
    protected $contaoTemplate;
    /**
     * @var LayoutModel
     */
    protected $layoutModel;

    public function __construct($twigTemplateName, $twigTemplateContext, $contaoTemplate, LayoutModel $layoutModel)
    {
        $this->twigTemplateName = $twigTemplateName;
        $this->twigTemplateContext = $twigTemplateContext;
        $this->contaoTemplate = $contaoTemplate;
        $this->layoutModel = $layoutModel;
    }

    /**
     * @return mixed
     */
    public function getTwigTemplateName()
    {
        return $this->twigTemplateName;
    }

    /**
     * @return mixed
     */
    public function getTwigTemplateContext()
    {
        return $this->twigTemplateContext;
    }

    /**
     * @return mixed
     */
    public function getContaoTemplate()
    {
        return $this->contaoTemplate;
    }

    /**
     * @param mixed $twigTemplateName
     */
    public function setTwigTemplateName($twigTemplateName): void
    {
        $this->twigTemplateName = $twigTemplateName;
    }

    /**
     * @param mixed $twigTemplateContext
     */
    public function setTwigTemplateContext($twigTemplateContext): void
    {
        $this->twigTemplateContext = $twigTemplateContext;
    }

    public function getLayoutModel(): LayoutModel
    {
        return $this->layoutModel;
    }
}
