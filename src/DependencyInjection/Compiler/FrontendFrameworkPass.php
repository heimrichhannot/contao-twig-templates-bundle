<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\TwigTemplatesBundle\DependencyInjection\Compiler;


use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FrontendFrameworkPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(FrontendFrameworkCollection::class))
        {
            return;
        }
        $definition = $container->findDefinition(FrontendFrameworkCollection::class);

        $taggedServices = $container->findTaggedServiceIds('huh.contao_twig_templates.framework');

        foreach ($taggedServices as $id => $tag)
        {
            $definition->addMethodCall('addFramework', array(new Reference($id)));
        }
    }
}