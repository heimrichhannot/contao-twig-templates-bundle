<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Test\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\DelegatingParser;
use Contao\TestCase\ContaoTestCase;
use HeimrichHannot\TwigTemplatesBundle\ContaoManager\Plugin;
use HeimrichHannot\TwigTemplatesBundle\HeimrichHannotTwigTemplatesBundle;

class PluginTest extends ContaoTestCase
{
    public function testInstantiation()
    {
        $this->assertInstanceOf(Plugin::class, new Plugin());
    }

    public function testGetBundles()
    {
        $plugin = new Plugin();

        /** @var BundleConfig[] $bundles */
        $bundles = $plugin->getBundles(new DelegatingParser());

        $this->assertCount(1, $bundles);
        $this->assertInstanceOf(BundleConfig::class, $bundles[0]);
        $this->assertEquals(HeimrichHannotTwigTemplatesBundle::class, $bundles[0]->getName());
        $this->assertEquals([ContaoCoreBundle::class], $bundles[0]->getLoadAfter());
    }
}
