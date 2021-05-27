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

    /**
     * @return mixed
     *
     * @deprecated Use app.request.locale instead. Will be removed in next version 3.0
     */
    public function getCurrentLanguage()
    {
        return $GLOBALS['TL_LANGUAGE'];
    }
}
