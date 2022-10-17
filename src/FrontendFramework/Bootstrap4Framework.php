<?php

/*
 * Copyright (c) 2022 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;

use Contao\LayoutModel;
use HeimrichHannot\TwigSupportBundle\Exception\TemplateNotFoundException;
use HeimrichHannot\TwigSupportBundle\Filesystem\TwigTemplateLocator;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\UtilsBundle\Util\Utils;

class Bootstrap4Framework extends AbstractFrontendFramework
{
    protected TwigTemplateLocator $templateLocator;
    private Utils $utils;

    /**
     * Bootstrap4Framework constructor.
     */
    public function __construct(Utils $utils, TwigTemplateLocator $templateLocator)
    {
        $this->templateLocator = $templateLocator;
        $this->utils = $utils;
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
        if (str_starts_with($templateName, 'ce_accordionSingle')) {
            $this->utils->accordion()->structureAccordionSingle($data);
        } elseif (str_starts_with($templateName, 'ce_accordionStart') || str_starts_with($templateName, 'ce_accordionStop')) {
            $this->utils->accordion()->structureAccordionStartStop($data);
        }
    }
}
