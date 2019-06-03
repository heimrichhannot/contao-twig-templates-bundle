<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\Twig;

use Contao\FrontendTemplate;
use Contao\LayoutModel;
use Contao\System;
use Contao\Widget;
use HeimrichHannot\TwigTemplatesBundle\DependencyInjection\Compiler\FrontendFrameworkPass;
use HeimrichHannot\TwigTemplatesBundle\Exception\TemplateTypeNotSupportedException;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;
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
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var LayoutModel|null
     */
    private $layout = null;

    public function __construct(ContainerInterface $container)
    {
        $this->templateUtil = $container->get('huh.utils.template');
        $this->classUtil = $container->get('huh.utils.class');
        $this->eventDispatcher = $container->get('event_dispatcher');
        $this->container = $container;
    }

    /**
     * Get current templates suffix from layout.
     *
     * @return string
     */
    public function getTemplateSuffix(): string
    {
        if (null === ($layout = $this->getLayout()))
        {
            return '';
        }

        if ($layout->ttFramework) {
            $frontendFramework = $this->container->get(FrontendFrameworkCollection::class)->getFramework($layout->ttFramework);
            return '_'.$frontendFramework->getAlias();
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
        return '';
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
        $layout = $this->getLayout();
        $frontendFramework = $this->container->get(FrontendFrameworkCollection::class)->getFramework($layout->ttFramework ? : 'contao');

        if ($object instanceof Widget)
        {
            $template = new FormTemplate($this->container, $frontendFramework);
        }
        elseif ($object instanceof FrontendTemplate)
        {
            $type = strtok($object->getName(), '_');

            switch ($type) {
                case 'ce':
                    $template = new ContentElementTemplate($this->container, $frontendFramework);
                    break;
                default:
                    $template = new DefaultTemplate($this->container, $frontendFramework);
            }
        }

        if (!$template) {
            throw new TemplateTypeNotSupportedException();
        }

        $template->setEntity($object);

        return $template;
    }

    protected function getLayout()
    {
        if (!$this->layout)
        {
            global $objPage;

            if (null === $objPage || null === ($this->layout = $this->container
                    ->get('huh.utils.model')
                    ->findModelInstanceByPk('tl_layout', $objPage->layout)
                ))
            {
                return null;
            }
        }
        return $this->layout;
    }
}
