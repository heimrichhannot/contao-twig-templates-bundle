<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

class FrontendFrameworkCollection
{
    /**
     * @var FrontendFrameworkInterface[]|array
     */
    protected $frameworks = [];

    public function addFramework(FrontendFrameworkInterface $framework)
    {
        $this->frameworks[$framework::getIdentifier()] = $framework;
    }

    /**
     * @return FrontendFrameworkInterface|null
     */
    public function getFramework(string $identifier)
    {
        if (isset($this->frameworks[$identifier])) {
            return $this->frameworks[$identifier];
        }

        return null;
    }

    public function getAllFrameworks()
    {
        return $this->frameworks;
    }
}
