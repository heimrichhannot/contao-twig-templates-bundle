<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use Contao\LayoutModel;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\Twig\AbstractTemplate;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractFrontendFramework
{
    /**
     * @var LayoutModel
     */
    protected $layout;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * AbstractFrontendFramework constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Return the framework alias. Is used for template suffix and database identification.
     * Example: bs4 for Bootstrap 4.
     *
     * @deprecated use FrontendFrameworkInterface::getIdentifier instead
     */
    abstract public function getAlias(): string;

    /**
     * Return the name of the framework. Can be an translation alias.
     */
    abstract public function getName(): string;

    /**
     * Prepare template data at the applyTwigTemplate method.
     */
    abstract public function generate(string &$templateName, array &$templateData): void;

    /**
     * Update template data and template name before render template.
     */
    abstract public function compile(string &$templateName, array &$templateData, AbstractTemplate $entity): void;

    public function prepare(PrepareTemplateCallback $callback): PrepareTemplateCallback
    {
        $templateName = $callback->getTemplateName();
        $templateData = $callback->getData();
        $this->generate($templateName, $templateData);
        $callback->setData($templateData);

        return $callback;
    }

    public function beforeRender(BeforeRenderCallback $callback): BeforeRenderCallback
    {
        $templateName = $callback->getTwigTemplateName();
        $templateData = $callback->getTwigTemplateContext();
        $entity = $callback->getLegacyTemplate();
        $this->compile($templateName, $templateData, $entity);
        $callback->setTwigTemplateName($templateName);
        $callback->setTwigTemplateContext($templateData);

        return $callback;
    }

    protected function getLayout()
    {
        if (!$this->layout) {
            global $objPage;

            if (null === $objPage || null === ($this->layout = $this->container
                    ->get('huh.utils.model')
                    ->findModelInstanceByPk('tl_layout', $objPage->layout)
                )) {
                return null;
            }
        }

        return $this->layout;
    }
}
