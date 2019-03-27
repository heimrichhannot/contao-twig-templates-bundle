<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
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
     * @return AbstractFrontendFramework|null
     */
    public function getFramework(string $alias)
    {
        if (isset($this->frameworks[$alias]))
        {
            return $this->frameworks[$alias];
        }
        return null;
    }

    public function getAllFrameworks()
    {
        return $this->frameworks;
    }
}