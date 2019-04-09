<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\TwigTemplatesBundle\FrontendFramework;


use HeimrichHannot\TwigTemplatesBundle\Twig\AbstractTemplate;

class Bootstrap4Framework extends AbstractFrontendFramework
{
    const SUPPORT_CUSTOM_FORMS = 'custom-forms';

    /**
     * Return the framework alias. Is used for template suffix and database identification.
     * Example: bs4 for Bootstrap 4
     *
     * @return string
     */
    public function getAlias(): string
    {
        return 'bs4';
    }

    /**
     * Return the name of the framework. Can be an translation alias.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'huh.twig.templates.framework.bs4';
    }

    /**
     * Prepare template data at the applyTwigTemplate method
     *
     * @param string $templateName
     * @param array $templateData
     */
    public function generate(string &$templateName, array &$templateData): void
    {
        $this->prepareAccordeons($templateName, $templateData);
    }

    public function compile(string &$templateName, array &$templateData, AbstractTemplate $entity): void
    {
        $this->supportCustomControl($templateName, $entity);
    }


    protected function supportCustomControl(string &$templateName, AbstractTemplate $entity)
    {
        if (null === ($layout = $this->getLayout()))
        {
            return;
        }
        if ($layout->ttUseFrameworkCustomControls && $entity->getSupport(static::SUPPORT_CUSTOM_FORMS))
        {
            $suffix = $this->container->get('huh.twig.template.factory')->getTemplateSuffix();
            $customFormTemplate = preg_replace('/'.$suffix.'$/', '', $templateName);
            $customFormTemplate .= '_custom_'.$this->getAlias();

            try {
                if ($this->container->get('huh.utils.template')->getTemplate($customFormTemplate) !== $customFormTemplate) {
                    $templateName = $customFormTemplate;
                }
            } catch (\Exception $e) {
                // if template not found, use default template
            }
        }
    }

    protected function prepareAccordeons(string &$templateName, array &$data)
    {
        // prepare template data for bootstrap
        switch ($templateName) {
            case 'ce_accordionSingle':
                $this->container->get('huh.utils.accordion')->structureAccordionSingle($data);
                break;

            case 'ce_accordionStart':
            case 'ce_accordionStop':
                $this->container->get('huh.utils.accordion')->structureAccordionStartStop($data);
                break;
        }
    }
}