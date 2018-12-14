<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;

use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderTwigTemplateEvent;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractTemplate
{
    protected $templateName;
    protected $templateData;
    protected $entity;

    /**
     * @var TemplateUtil
     */
    protected $templateUtil;
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * AbstractTemplate constructor.
     */
    public function __construct(TemplateUtil $templateUtil, EventDispatcherInterface $eventDispatcher)
    {
        $this->templateUtil = $templateUtil;
        $this->eventDispatcher = $eventDispatcher;
    }

    abstract public function getType(): string;

    /**
     * Set the form entity, e.g. Widget, Module,...
     *
     *
     * @param $entity
     */
    public function setEntity($entity)
    {
        $this->prepareData($entity);
        $this->entity = $entity;
    }

    /**
     * Render the widget.
     *
     * Uses $this->templateName and $this->templateData
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function render()
    {
        $event = $this->eventDispatcher->dispatch(
            BeforeRenderTwigTemplateEvent::NAME,
            new BeforeRenderTwigTemplateEvent($this->getType(), $this->templateName, $this->templateData, $this->entity)
        );

        return $this->templateUtil->renderTwigTemplate($event->getTemplateName(), $event->getTemplateData());
    }

    /**
     * Prepare templateName and templateData from entity (Widget, Module, ContentElement,...).
     *
     * @param $entity
     *
     * @return mixed
     */
    abstract protected function prepareData($entity);
}
