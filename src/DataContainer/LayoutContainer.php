<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\DataContainer;

use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use Symfony\Contracts\Translation\TranslatorInterface;

class LayoutContainer
{
    protected FrontendFrameworkCollection $collection;

    protected TranslatorInterface $translator;

    public function __construct(FrontendFrameworkCollection $collection, TranslatorInterface $translator)
    {
        $this->collection = $collection;
        $this->translator = $translator;
    }

    /**
     * Returns all registered frameworks as one-dimensional array for options_callback.
     *
     * @return array
     */
    public function onTtFrameworkOptionsCallback()
    {
        $frameworks = $this->collection->getAllFrameworks();
        $options = [];

        if ($frameworks) {
            foreach ($frameworks as $framework) {
                $options[$framework::getIdentifier()] = $this->translator->trans($framework::getLabel());
            }
        }

        return $options;
    }
}
