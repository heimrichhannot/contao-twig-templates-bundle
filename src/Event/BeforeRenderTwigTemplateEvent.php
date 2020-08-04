<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class BeforeRenderTwigTemplateEvent.
 */
class BeforeRenderTwigTemplateEvent extends Event
{
    const NAME = 'huh.twig.beforeRenderTemplate';

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

    public function getType(): string
    {
        return $this->type;
    }

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
