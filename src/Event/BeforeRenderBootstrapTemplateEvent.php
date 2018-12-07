<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\BootstrapTemplatesBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class BeforeRenderBootstrapTemplateEvent extends Event
{
    const NAME = 'huh.bootstrap.beforeRenderTemplate';

    protected $templateName;
    protected $templateData;
    protected $entity;
    /**
     * @var string
     */
    private $type;

    /**
     * BeforeRenderEvent constructor.
     *
     * @param string $type
     * @param string $templateName
     * @param $templateData
     * @param $entity
     */
    public function __construct(string $type, string $templateName, $templateData, $entity)
    {
        $this->templateName = $templateName;
        $this->templateData = $templateData;
        $this->entity = $entity;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * @param mixed $templateName
     */
    public function setTemplateName($templateName): void
    {
        $this->templateName = $templateName;
    }

    /**
     * @return mixed
     */
    public function getTemplateData()
    {
        return $this->templateData;
    }

    /**
     * @param mixed $templateData
     */
    public function setTemplateData($templateData): void
    {
        $this->templateData = $templateData;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity): void
    {
        $this->entity = $entity;
    }
}
