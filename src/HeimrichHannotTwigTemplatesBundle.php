<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle;

use HeimrichHannot\TwigTemplatesBundle\DependencyInjection\Compiler\FrontendFrameworkPass;
use HeimrichHannot\TwigTemplatesBundle\DependencyInjection\HeimrichHannotTwigTemplatesExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotTwigTemplatesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FrontendFrameworkPass());
    }

    public function getContainerExtension()
    {
        return new HeimrichHannotTwigTemplatesExtension();
    }
}
