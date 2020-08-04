<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;

interface FrontendFrameworkInterface
{
    /**
     * Return the framework alias. Is used for template suffix and database identification.
     * Example: bs4 for Bootstrap 4.
     */
    public static function getIdentifier(): string;

    /**
     * Prepare template data when applying twig template.
     */
    public function prepare(PrepareTemplateCallback $callback): PrepareTemplateCallback;

    /**
     * Update template date just before rendering the template.
     */
    public function beforeRender(BeforeRenderCallback $callback): BeforeRenderCallback;
}
