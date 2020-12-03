<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use HeimrichHannot\TwigSupportBundle\HeimrichHannotTwigSupportBundle;
use HeimrichHannot\TwigTemplatesBundle\HeimrichHannotTwigTemplatesBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(HeimrichHannotTwigTemplatesBundle::class)->setLoadAfter([
                ContaoCoreBundle::class,
                HeimrichHannotTwigSupportBundle::class,
                'formhybrid',
            ]),
        ];
    }
}
