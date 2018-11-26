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

    public function parseTemplate(Template $template)
    {
        $this->applyBootstrapTemplate($template);
    }

    public function parseWidget($strBuffer, Widget $widget)
    {
        return $strBuffer;
//        $widget->template .= '_bs';
//        $widget->template = 'form_text';

        return $widget->inherit();
    }

    public function applyBootstrapTemplate(Template $template)
    {
        global $objPage;

        // deactivate if AMP mode is active
        $ampMode = $this->container->get('huh.utils.container')->isBundleActive('HeimrichHannot\AmpBundle\HeimrichHannotContaoAmpBundle') &&
            $this->container->get('huh.request')->getGet('amp');

        if ($ampMode || null === ($layout = $this->container->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout)) ||
            !$layout->addBootstrapTemplates) {
            return;
        }

        try {
            TemplateLoader::getPath($template->getName().static::SUFFIX, 'html5');
        } catch (\Exception $e) {
            // template not found
            return;
        }

        // prepare template data for amp
        switch ($template->getName()) {
            case 'ce_accordionSingle':
                $data = $template->getData();

                $this->container->get('huh.utils.accordion')->structureAccordionSingle($data);

                $template->setData($data);

                break;

            case 'ce_accordionStart':
            case 'ce_accordionStop':
                $data = $template->getData();

                $this->container->get('huh.utils.accordion')->structureAccordionStartStop($data);

                $template->setData($data);

                break;
        }

        // custom controls
        $template->addBootstrapCustomControls = $layout->addBootstrapCustomControls;

        // set bootstrap template
        $template->setName($template->getName().static::SUFFIX);
    }
}
