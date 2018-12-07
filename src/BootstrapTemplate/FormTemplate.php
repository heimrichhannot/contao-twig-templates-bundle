<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\BootstrapTemplatesBundle\BootstrapTemplate;

use Contao\System;
use HeimrichHannot\BootstrapTemplatesBundle\EventListener\HookListener;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;

class FormTemplate extends AbstractTemplate
{
    const TYPE = 'widget';

    /**
     * @var ClassUtil
     */
    protected $classUtil;
    protected $widgetSupportsCustomForms;

    /**
     * @param ClassUtil $classUtil
     */
    public function setClassUtil(ClassUtil $classUtil): void
    {
        $this->classUtil = $classUtil;
    }

    public function supportCustomForm()
    {
        if ($this->widgetSupportsCustomForms) {
            try {
                $customFormTemplate = $this->templateName.HookListener::CUSTOM_SUFFIX;

                if ($this->templateUtil->getTemplate($customFormTemplate) !== $customFormTemplate) {
                    $this->templateName = $customFormTemplate;
                }
            } catch (\Exception $e) {
                // if template not found, use default template
            }
        }
    }

    public function prepareData($entity)
    {
        $this->templateName = $entity->template;

        $this->templateData = $this->classUtil->jsonSerialize($entity, [], [
            'includeProperties' => true,
            'ignorePropertyVisibility' => true,
        ]);

        if (method_exists($entity, 'getOptions')) {
            $this->templateData['arrOptions'] = System::getContainer()->get('huh.utils.class')->callInaccessibleMethod($entity, 'getOptions');
        }

        $this->widgetSupportsCustomForms = $entity->addBootstrapCustomControls;
    }

    public function getType(): string
    {
        return static::TYPE;
    }
}
