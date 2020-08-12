<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Event;

class BeforeRenderCallback
{
    protected $twigTemplateName;
    protected $twigTemplateContext;
    protected $contaoTemplate;
    protected $legacyTemplate;

    public function __construct($twigTemplateName, $twigTemplateContext, $contaoTemplate, $legacyTemplate)
    {
        $this->twigTemplateName = $twigTemplateName;
        $this->twigTemplateContext = $twigTemplateContext;
        $this->contaoTemplate = $contaoTemplate;
        $this->legacyTemplate = $legacyTemplate;
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
     * @return mixed
     *
     * @deprecated lagacy template support will be removed in next major version
     */
    public function getLegacyTemplate()
    {
        return $this->legacyTemplate;
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
}
