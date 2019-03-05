<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;

use Contao\FrontendTemplate;
use Contao\System;
use Contao\Widget;
use HeimrichHannot\TwigTemplatesBundle\Exception\TemplateTypeNotSupportedException;
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
     * Get the custom controls template name based on given template name.
     *
     * @return string
     */
    public function getCustomControlsTemplateName(string $templateName)
    {
        global $objPage;

        if (null === $objPage || null === ($layout = System::getContainer()->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout))) {
            return $templateName;
        }

        if ($layout->ttFramework && true === (bool) $layout->ttUseFrameworkCustomControls) {
            $suffix = $this->getTemplateSuffix();
            $templateName = preg_replace('/'.$suffix.'$/', '', $templateName);
            $templateName .= $this->getCustomControlsTemplateSuffix();
        }

        return $templateName;
    }

    /**
     * Get custom controls template suffix.
     *
     * @return string
     */
    public function getCustomControlsTemplateSuffix(): string
    {
        global $objPage;

        $suffix = '';

        if (null === $objPage || null === ($layout = System::getContainer()->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout))) {
            return $suffix;
        }

        if ($layout->ttFramework && true === (bool) $layout->ttUseFrameworkCustomControls) {
            $suffix = '_custom_'.$layout->ttFramework;
        }

        return $suffix;
    }

    /**
     * Get current templates suffix from layout.
     *
     * @return string
     */
    public function getTemplateSuffix(): string
    {
        global $objPage;

        if (null === $objPage || null === ($layout = System::getContainer()->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout))) {
            return '';
        }

        if ($layout->ttFramework) {
            return '_'.$layout->ttFramework;
        }

        if ($layout->ttUseTwig) {
            return $this->getCoreTemplateSuffix();
        }

        return '';
    }

    /**
     * Get the contao core twig templates suffix.
     *
     * @return string
     */
    public function getCoreTemplateSuffix(): string
    {
        return '_core';
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
            $type = strtok($object->getName(), '_');

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
