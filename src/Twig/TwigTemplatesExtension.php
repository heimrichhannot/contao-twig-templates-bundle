<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigTemplatesExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getCurrentLanguage', [$this, 'getCurrentLanguage']),
        ];
    }

    public function getCurrentLanguage()
    {
        return $GLOBALS['TL_LANGUAGE'];
    }
}
