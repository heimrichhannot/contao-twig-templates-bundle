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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class HookListener implements FrameworkAwareInterface, ContainerAwareInterface
{
    use FrameworkAwareTrait;
    use ContainerAwareTrait;

    const SUFFIX = '_bs';

    public function parseTemplate(Template $template)
    {
        global $objPage;

        if (null === ($layout = $this->container->get('huh.utils.model')->findModelInstanceByPk('tl_layout', $objPage->layout)) ||
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
        }

        // custom controls
        $template->addBootstrapCustomControls = $layout->addBootstrapCustomControls;

        // set bootstrap template
        $template->setName($template->getName().static::SUFFIX);
    }
}
