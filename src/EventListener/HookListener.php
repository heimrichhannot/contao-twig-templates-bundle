<?php

/*
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\BootstrapTemplatesBundle\EventListener;

use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Contao\Template;
use Contao\TemplateLoader;
use Contao\Widget;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class HookListener implements FrameworkAwareInterface, ContainerAwareInterface
{
    use FrameworkAwareTrait;
    use ContainerAwareTrait;

    const SUFFIX = '_bs';
    const CUSTOM_SUFFIX = '_custom';

    /**
     * Hook for applying bootstrap templates for elements and modules.
     *
     * @param Template $template
     */
    public function parseTemplate(Template $template)
    {
        $result = $this->applyBootstrapTemplate($template->getName(), $template->getData());

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
     * @param $buffer
     * @param Widget $widget
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function parseWidget($buffer, Widget $widget)
    {
        $data = $this->container->get('huh.utils.class')->jsonSerialize($widget, [], [
            'ignorePropertyVisibility' => true,
        ]);

        $result = $this->applyBootstrapTemplate($widget->template, $data);

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
     * Applies bootstrap template.
     *
     * @param string $templateName
     * @param array  $data
     *
     * @return array|bool
     */
    public function applyBootstrapTemplate(string $templateName, array $data)
    {
        global $objPage;

        // deactivate if AMP mode is active
        $ampMode = $this->container->get('huh.utils.container')->isBundleActive('HeimrichHannot\AmpBundle\HeimrichHannotContaoAmpBundle') &&
            $this->container->get('huh.request')->getGet('amp');

        if ($ampMode || null === ($layout = $this->container->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout)) ||
            !$layout->addBootstrapTemplates) {
            return false;
        }

		try {
			TemplateLoader::getPath($templateName.static::SUFFIX, 'html5');
		} catch (\Exception $e) {
			// template not found
			return false;
		}

        // prepare template data for amp
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
        $data['addBootstrapCustomControls'] = $layout->addBootstrapCustomControls;

        // set bootstrap template
        $bsTemplateName = $templateName.static::SUFFIX;

        return [$bsTemplateName, $data];
    }
}
