<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;

use Contao\System;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderTwigTemplateEvent;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkInterface;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractTemplate.
 *
 * @deprecated Will be removed in next major version
 */
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
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var FrontendFrameworkInterface
     */
    protected $frontendFramework;
    /**
     * @var array
     */
    protected $support;
    protected $layout;

    /**
     * AbstractTemplate constructor.
     */
    public function __construct(ContainerInterface $container, FrontendFrameworkInterface $frontendFramework)
    {
        $this->templateUtil = $container->get('huh.utils.template');
        $this->eventDispatcher = $container->get('event_dispatcher');
        $this->container = $container;
        $this->frontendFramework = $frontendFramework;
    }

    abstract public function getType(): string;

    /**
     * Set the form entity, e.g. Widget, Module,...
     *
     * @param $entity
     */
    public function setEntity($entity)
    {
        $this->prepareData($entity);
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Render the widget.
     *
     * Uses $this->templateName and $this->templateData
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @return string
     */
    public function render()
    {
        $callback = $this->frontendFramework->beforeRender(new BeforeRenderCallback(
            $this->templateName, $this->templateData, $this->entity, $this, $this->getLayout()
        ));

        /** @var BeforeRenderTwigTemplateEvent $event */
        $event = $this->eventDispatcher->dispatch(
            BeforeRenderTwigTemplateEvent::NAME,
            new BeforeRenderTwigTemplateEvent(
                $this->getType(), $callback->getTwigTemplateName(), $callback->getTwigTemplateContext(), $this->entity)
        );

        return $this->templateUtil->renderTwigTemplate($event->getTemplateName(), array_merge(\is_array($event->getTemplateData()) ? $event->getTemplateData() : [], ['_entity' => $this->getEntity()]));
    }

    /**
     * Set if element support a feature.
     *
     * @param mixed $value
     */
    public function addSupport(string $key, $value)
    {
        $this->support[$key] = $value;
    }

    /**
     * Check if element supports a feature
     * Return false, if support is not set or false.
     *
     * @return bool
     */
    public function hasSupport(string $key)
    {
        return isset($this->support[$key]) && false !== $this->support;
    }

    /**
     * Get the value for a support feature.
     * Return false, if feature not found.
     *
     * @return bool|mixed
     */
    public function getSupport(string $key)
    {
        if (isset($this->support[$key])) {
            return $this->support[$key];
        }

        return false;
    }

    public function getLayout()
    {
        if (!$this->layout) {
            global $objPage;

            if (null === $objPage || null === ($this->layout = System::getContainer()
                    ->get('huh.utils.model')
                    ->findModelInstanceByPk('tl_layout', $objPage->layout)
                )) {
                return null;
            }
        }

        return $this->layout;
    }

    /**
     * Prepare templateName and templateData from entity (Widget, Module, ContentElement,...).
     *
     * @param $entity
     */
    abstract protected function prepareData($entity);
}
