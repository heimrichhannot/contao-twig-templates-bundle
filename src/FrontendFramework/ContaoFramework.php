<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use HeimrichHannot\TwigTemplatesBundle\Twig\AbstractTemplate;

class ContaoFramework extends AbstractFrontendFramework
{
    /**
     * Return the framework alias. Is used for template suffix and database identification.
     * Example: bs4 for Bootstrap 4.
     */
    public function getAlias(): string
    {
        return 'contao';
    }

    /**
     * Return the name of the framework. Can be an translation alias.
     */
    public function getName(): string
    {
        return 'huh.twig.templates.framework.contao';
    }

    /**
     * {@inheritdoc}
     */
    public function generate(string &$templateName, array &$templateData): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function compile(string &$templateName, array &$templateData, AbstractTemplate $entity): void
    {
    }
}
