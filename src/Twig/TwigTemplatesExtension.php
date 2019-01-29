<?php
/**
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;


use Contao\StringUtil;
use Contao\System;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TwigTemplatesExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getCurrentLanguage', [$this, 'getCurrentLanguage'])
        ];
    }

    public function getCurrentLanguage()
    {
        return $GLOBALS['TL_LANGUAGE'];
    }
}