<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use Contao\LayoutModel;
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
     * @return string
     */
    abstract public function getAlias(): string;

    /**
     * Return the name of the framework. Can be an translation alias.
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Prepare template data at the applyTwigTemplate method.
     *
     * @param string $templateName
     * @param array  $templateData
     */
    abstract public function generate(string &$templateName, array &$templateData): void;

    /**
     * Update template data and template name before render template.
     *
     * @param string           $templateName
     * @param array            $templateData
     * @param AbstractTemplate $entity
     */
    abstract public function compile(string &$templateName, array &$templateData, AbstractTemplate $entity): void;

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
