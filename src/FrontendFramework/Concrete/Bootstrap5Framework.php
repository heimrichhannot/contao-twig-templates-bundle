<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework\Concrete;

use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\AbstractFrontendFramework;
use HeimrichHannot\UtilsBundle\Accordion\AccordionUtil;
use HeimrichHannot\UtilsBundle\String\StringUtil;

class Bootstrap5Framework extends AbstractFrontendFramework
{
    /**
     * @var AccordionUtil
     */
    protected $accordionUtil;
    /**
     * @var StringUtil
     */
    protected $stringUtil;

    /**
     * Bootstrap4Framework constructor.
     */
    public function __construct(AccordionUtil $accordionUtil, StringUtil $stringUtil)
    {
        $this->accordionUtil = $accordionUtil;
        $this->stringUtil = $stringUtil;
    }

    public static function getIdentifier(): string
    {
        return 'bs5';
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
        return $callback;
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
