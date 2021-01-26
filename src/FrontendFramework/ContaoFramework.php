<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;

class ContaoFramework implements FrontendFrameworkInterface
{
    public static function getIdentifier(): string
    {
        return 'contao';
    }

    public static function getLabel(): string
    {
        return 'huh.twig.templates.framework.contao';
    }

    public function prepare(PrepareTemplateCallback $callback): PrepareTemplateCallback
    {
        return $callback;
    }

    public function beforeRender(BeforeRenderCallback $callback): BeforeRenderCallback
    {
        return $callback;
    }
}
