<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

abstract class AbstractFrontendFramework implements FrontendFrameworkInterface
{
    public static function getLabel(): string
    {
        return 'huh.twig.templates.framework.'.static::getIdentifier();
    }
}
