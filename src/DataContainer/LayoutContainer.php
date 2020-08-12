<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\DataContainer;

use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LayoutContainer
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns all registered frameworks as one-dimensional array for options_callback.
     *
     * @return array
     */
    public function getFrameworkOptions()
    {
        return array_keys($this->container->get(FrontendFrameworkCollection::class)->getAllFrameworks());
    }

    /**
     * Returns the translations for the frameworks as reference for options reference.
     *
     * @return array
     */
    public function getFrameworkNameReference()
    {
        $translations = [];
        /** @var FrontendFrameworkInterface[] $frameworks */
        $frameworks = $this->container->get(FrontendFrameworkCollection::class)->getAllFrameworks();

        foreach ($frameworks as $framework) {
            $translations[$framework::getIdentifier()] = $this->container->get('translator')->trans($framework->getName());
        }

        return $translations;
    }
}
