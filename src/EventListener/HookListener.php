<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use Contao\Template;
use Contao\TemplateLoader;
use Contao\Widget;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class HookListener implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const CUSTOM_SUFFIX = '_custom';

    /**
     * Hook for applying bootstrap templates for elements and modules.
     *
     * @param Template $template
     */
    public function parseTemplate(Template $template)
    {
        if (!$this->container->get('huh.utils.container')->isFrontend()) {
            return;
        }
        $result = $this->applyTwigTemplate($template->getName(), $template->getData());

        if (false === $result) {
            return;
        }

        list($templateName, $templateData) = $result;

        $template->setName($templateName);
        $template->setData($templateData);
    }

    /**
     * Hook for applying bootstrap templates for elements and modules.
     *
     * @param        $buffer
     * @param Widget $widget
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function parseWidget($buffer, Widget $widget)
    {
        if (!$this->container->get('huh.utils.container')->isFrontend()) {
            return $buffer;
        }
        $data = $this->container->get('huh.utils.class')->jsonSerialize(
            $widget,
            [],
            [
                'ignorePropertyVisibility' => true,
            ]
        );

        $result = $this->applyTwigTemplate($widget->template, $data);

        if (false === $result) {
            return $buffer;
        }

        list($templateName, $templateData) = $result;

        $widget->template = $templateName;

        foreach ($templateData as $k => $v) {
            $widget->{$k} = $v;
        }

        return $widget->inherit();
    }

    /**
     * Applies twig template.
     *
     * @param string $templateName Template name
     * @param array  $data         Template data
     *
     * @return array|bool
     */
    public function applyTwigTemplate(string $templateName, array $data)
    {
        global $objPage;

        // deactivate if AMP mode is active
        $ampMode = $this->container->get('huh.utils.container')->isBundleActive('HeimrichHannot\AmpBundle\HeimrichHannotContaoAmpBundle')
                   && $this->container->get('huh.request')->getGet('amp');

        if ($ampMode || null === ($layout = $this->container->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout))) {
            return false;
        }

        $suffix = $layout->ttFramework ? ('_'.$layout->ttFramework) : '';

        $path = null;

        try {
            $path = TemplateLoader::getPath($templateName.$suffix, 'html5');
        } catch (\Exception $e) {
            $path = null;
        }

        if ($layout->ttUseTwig) {
            $suffix = '_core';

            try {
                $path = TemplateLoader::getPath($templateName.$suffix, 'html5');
            } catch (\Exception $e) {
                $path = null;
            }
        }

        // template not found
        if (null === $path) {
            return false;
        }

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

        // custom controls
        $data['ttUseFrameworkCustomControls'] = $layout->ttUseFrameworkCustomControls;

        // set framework template
        $twigTemplateName = $templateName.$suffix;

        return [$twigTemplateName, $data];
    }
}
