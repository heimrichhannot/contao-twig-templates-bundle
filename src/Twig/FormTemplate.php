<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;


use Contao\Widget;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\Bootstrap4Framework;

class FormTemplate extends AbstractTemplate
{
    const TYPE = 'widget';

    /**
     * Prepare templateName and templateData from entity (Widget, Module, ContentElement,...).
     *
     * @param Widget $entity
     * @throws \ReflectionException
     */
    public function prepareData($entity)
    {
        $this->templateName = $entity->template;

        $this->templateData = $this->container->get('huh.utils.class')->jsonSerialize(
            $entity,
            [],
            [
                'includeProperties' => true,
                'ignorePropertyVisibility' => true,
            ]
        );

        if (method_exists($entity, 'getOptions')) {
            $this->templateData['arrOptions'] = $this->container->get('huh.utils.class')->callInaccessibleMethod($entity, 'getOptions');
        }
    }

    public function getType(): string
    {
        return static::TYPE;
    }
}
