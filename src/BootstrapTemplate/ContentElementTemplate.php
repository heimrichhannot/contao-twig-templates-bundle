<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\BootstrapTemplatesBundle\BootstrapTemplate;

use Contao\FrontendTemplate;

class ContentElementTemplate extends DefaultTemplate
{
    const TYPE = 'contentelement';

    /**
     * Prepare templateName and templateData from entity (Widget, Module, ContentElement,...).
     *
     * @param FrontendTemplate $entity
     *
     * @return mixed
     */
    public function prepareData($entity)
    {
        $this->templateName = $entity->getName();
        $this->templateData = $entity->getData();
    }

    public function getType(): string
    {
        return static::TYPE;
    }
}
