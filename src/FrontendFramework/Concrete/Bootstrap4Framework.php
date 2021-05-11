<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework\Concrete;

use Contao\LayoutModel;
use HeimrichHannot\TwigSupportBundle\Exception\TemplateNotFoundException;
use HeimrichHannot\TwigSupportBundle\Filesystem\TwigTemplateLocator;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\AbstractFrontendFramework;
use HeimrichHannot\UtilsBundle\Accordion\AccordionUtil;
use HeimrichHannot\UtilsBundle\String\StringUtil;

class Bootstrap4Framework extends AbstractFrontendFramework
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
     * @var StringUtil
     */
    protected $stringUtil;

    /**
     * Bootstrap4Framework constructor.
     */
    public function __construct(AccordionUtil $accordionUtil, TwigTemplateLocator $templateLocator, StringUtil $stringUtil)
    {
        $this->accordionUtil = $accordionUtil;
        $this->templateLocator = $templateLocator;
        $this->stringUtil = $stringUtil;
    }

    public static function getIdentifier(): string
    {
        return 'bs4';
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
            $customFormTemplate .= 'custom_'.static::getIdentifier();

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
        if ($this->stringUtil->startsWith($templateName, 'ce_accordionSingle')) {
            $this->accordionUtil->structureAccordionSingle($data);
        } elseif ($this->stringUtil->startsWith($templateName, 'ce_accordionStart') ||
                  $this->stringUtil->startsWith($templateName, 'ce_accordionStop')) {
            $this->accordionUtil->structureAccordionStartStop($data);
        }
    }
}
