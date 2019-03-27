<?php

/*
 * Copyright (c) 2019 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use Contao\LayoutModel;
use Contao\Template;
use Contao\TemplateLoader;
use Contao\Widget;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class HookListener implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const CUSTOM_SUFFIX = '_custom';

    /**
     * @var LayoutModel
     */
    protected $layout;

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
        // deactivate if AMP mode is active
        $ampMode = $this->container->get('huh.utils.container')->isBundleActive('HeimrichHannot\AmpBundle\HeimrichHannotContaoAmpBundle')
                   && $this->container->get('huh.request')->getGet('amp');

        if ($ampMode) {
            return false;
        }

        $path              = null;
        $prefixedTemplates = TemplateLoader::getPrefixedFiles($templateName);

        // provide suffixed templates in priority order
        $suffixedTemplates = [
            $templateName.$this->container->get('huh.twig.template.factory')->getTemplateSuffix(),
            $templateName.$this->container->get('huh.twig.template.factory')->getCoreTemplateSuffix(),
            $templateName,
        ];

        $templates          = array_intersect($suffixedTemplates, $prefixedTemplates);
        $customTemplateName = reset($templates);

        if ($customTemplateName === $templateName) {
            return false;
        }

        try {
            $path = TemplateLoader::getDefaultPath($customTemplateName, 'html5');
        } catch (\Exception $e) {
            $path = null;
        }

        // template not found
        if (null === $path) {
            return false;
        }

        if (null !== ($layout = $this->getLayout()) && null !== ($frontendFramework = $this->container
                ->get(FrontendFrameworkCollection::class)->getFramework($layout->ttFramework))
        ) {
            $frontendFramework->generate($templateName, $data);
        }

        return [$customTemplateName, $data];
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
