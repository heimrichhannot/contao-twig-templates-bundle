<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\BootstrapTemplatesBundle\BootstrapTemplate;

use Contao\FrontendTemplate;
use Contao\Widget;
use HeimrichHannot\BootstrapTemplatesBundle\Exception\TemplateTypeNotSupportedException;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TemplateFactory
{
    /**
     * @var TemplateUtil
     */
    private $templateUtil;
    /**
     * @var ClassUtil
     */
    private $classUtil;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(TemplateUtil $templateUtil, ClassUtil $classUtil, EventDispatcherInterface $eventDispatcher)
    {
        $this->templateUtil = $templateUtil;
        $this->classUtil = $classUtil;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param $object
     *
     * @throws TemplateTypeNotSupportedException
     * @throws \ReflectionException
     *
     * @return FormTemplate
     */
    public function createInstance($object)
    {
        if ($object instanceof Widget) {
            $template = new FormTemplate($this->templateUtil, $this->eventDispatcher);
            $template->setClassUtil($this->classUtil);
        } elseif ($object instanceof FrontendTemplate) {
            $type = strtok($object->getName());

            switch ($type) {
                case 'ce':
                    $template = new ContentElementTemplate($this->templateUtil, $this->eventDispatcher);

                    break;

                default:
                    $template = new DefaultTemplate($this->templateUtil, $this->eventDispatcher);
            }
        }

        if (!$template) {
            throw new TemplateTypeNotSupportedException();
        }

        $template->setEntity($object);

        return $template;
    }
}
