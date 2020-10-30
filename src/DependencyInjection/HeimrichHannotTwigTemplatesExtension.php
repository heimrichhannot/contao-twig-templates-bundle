<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class HeimrichHannotTwigTemplatesExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // TODO: Implement load() method.
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('twig', ['paths' => [
            '%kernel.project_dir%/vendor/heimrichhannot/contao-twig-templates-bundle/src/Resources/views' => 'HeimrichHannotTwigTemplates',
        ]]);
    }
}
