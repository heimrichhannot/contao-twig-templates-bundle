<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use Contao\LayoutModel;
use HeimrichHannot\TwigSupportBundle\Exception\TemplateNotFoundException;
use HeimrichHannot\TwigSupportBundle\Filesystem\TwigTemplateLocator;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\UtilsBundle\Accordion\AccordionUtil;

class Bootstrap4Framework implements FrontendFrameworkInterface
{
    /**
     * @var AccordionUtil
     */
    protected $accordionUtil;

    /**
     * @var TwigTemplateLocator
     */
    protected $templateLocator;

    /**
     * Bootstrap4Framework constructor.
     */
    public function __construct(AccordionUtil $accordionUtil, TwigTemplateLocator $templateLocator)
    {
        $this->accordionUtil = $accordionUtil;
        $this->templateLocator = $templateLocator;
    }

    public static function getIdentifier(): string
    {
        return 'bs4';
    }

    public static function getLabel(): string
    {
        return 'huh.twig.templates.framework.bs4';
    }

    public function prepare(PrepareTemplateCallback $callback): PrepareTemplateCallback
    {
        $templateName = $callback->getTemplateName();
        $templateData = $callback->getData();
        $this->prepareAccordions($templateName, $templateData);
        $callback->setData($templateData);

        return $callback;
    }

    public function beforeRender(BeforeRenderCallback $callback): BeforeRenderCallback
    {
        $templateName = $callback->getTwigTemplateName();
        $this->supportCustomControl($templateName, $callback->getLayoutModel());
        $callback->setTwigTemplateName($templateName);

        return $callback;
    }

    protected function supportCustomControl(string &$templateName, LayoutModel $layout)
    {
        if ($layout->ttUseFrameworkCustomControls) {
            $customFormTemplate = preg_replace('/'.static::getIdentifier().'$/', '', $templateName);
            $customFormTemplate .= '_custom_'.static::getIdentifier();

            try {
                $templateName = $this->templateLocator->getTemplatePath($customFormTemplate);
            } catch (TemplateNotFoundException $e) {
                // if template not found, use default template
            }
        }
    }

    protected function prepareAccordions(string &$templateName, array &$data)
    {
        // prepare template data for bootstrap
        switch ($templateName) {
            case 'ce_accordionSingle':
                $this->accordionUtil->structureAccordionSingle($data);

                break;

            case 'ce_accordionStart':
            case 'ce_accordionStop':
                $this->accordionUtil->structureAccordionStartStop($data);

                break;
        }
    }
}
