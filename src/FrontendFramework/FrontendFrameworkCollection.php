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
     * @var AbstractFrontendFramework[]|array
     */
    protected $frameworks = [];

    public function addFramework(AbstractFrontendFramework $framework)
    {
        $this->frameworks[$framework->getAlias()] = $framework;
    }

    /**
     * @param string $alias
     *
     * @return AbstractFrontendFramework|null
     */
    public function getFramework(string $alias)
    {
        if (isset($this->frameworks[$alias])) {
            return $this->frameworks[$alias];
        }

        return null;
    }

    public function getAllFrameworks()
    {
        return $this->frameworks;
    }
}
