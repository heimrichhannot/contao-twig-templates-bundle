<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use HeimrichHannot\TwigTemplatesBundle\Twig\AbstractTemplate;

class ContaoFramework extends AbstractFrontendFramework
{
    /**
     * Return the framework alias. Is used for template suffix and database identification.
     * Example: bs4 for Bootstrap 4
     *
     * @return string
     */
    public function getAlias(): string
    {
        return 'contao';
    }

    /**
     * Return the name of the framework. Can be an translation alias.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'huh.twig.templates.framework.contao';
    }

    /**
     * @inheritDoc
     */
    public function generate(string &$templateName, array &$templateData): void
    {
    }

    /**
     * @inheritDoc
     */
    public function compile(string &$templateName, array &$templateData, AbstractTemplate $entity): void
    {
    }
}