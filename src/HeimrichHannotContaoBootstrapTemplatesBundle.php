<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\BootstrapTemplatesBundle;

use HeimrichHannot\BootstrapTemplatesBundle\DependencyInjection\BootstrapTemplatesExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotContaoBootstrapTemplatesBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new BootstrapTemplatesExtension();
    }
}
