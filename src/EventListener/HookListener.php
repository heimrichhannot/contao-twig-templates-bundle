<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use Contao\Config;
use Contao\LayoutModel;
use Contao\System;
use Contao\Template;
use Contao\TemplateLoader;
use Contao\Widget;
use HeimrichHannot\TwigSupportBundle\EventListener\RenderListener;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkInterface;
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
     */
    public function parseTemplate(Template $template)
    {
        if (!$this->container->get('huh.utils.container')->isFrontend()) {
            return;
        }
        $layout = $this->getLayout();

        if (!$layout->ttUseTwig) {
            return;
        }
        $result = $this->applyTwigTemplate($template->getName(), $template->getData());

        if (false === $result) {
            return;
        }

        [$templateName, $templateData] = $result;

        $template->setName($templateName);
        $template->setData($templateData);
    }

    /**
     * Hook for applying bootstrap templates for elements and modules.
     *
     * @param $buffer
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
        $layout = $this->getLayout();

        if (!$layout->ttUseTwig) {
            return $buffer;
        }

        $data = $this->container->get('huh.utils.class')->jsonSerialize(
            $widget,
            [],
            [
                'ignorePropertyVisibility' => true,
            ]
        );

        if ('twig_template_proxy' === $widget->template && class_exists("HeimrichHannot\TwigSupportBundle\EventListener\RenderListener") && $widget->{RenderListener::TWIG_TEMPLATE}) {
            $data[RenderListener::TWIG_TEMPLATE] = $widget->{RenderListener::TWIG_TEMPLATE};
            $data[RenderListener::TWIG_CONTEXT] = $widget->{RenderListener::TWIG_CONTEXT};
        }

        $result = $this->applyTwigTemplate($widget->template, $data);

        if (false === $result) {
            return $buffer;
        }

        [$templateName, $templateData] = $result;

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

        if ($ampMode || !empty($data['customTpl'])) {
            return false;
        }

        if ('twig_template_proxy' === $templateName && class_exists("HeimrichHannot\TwigSupportBundle\EventListener\RenderListener")) {
            $templateName = $data[RenderListener::TWIG_TEMPLATE];
            $data = $data[RenderListener::TWIG_CONTEXT];
        }

        $path = null;
        $prefixedTemplates = TemplateLoader::getPrefixedFiles($templateName);

        // provide suffixed templates in priority order
        $suffixedTemplates = [
            $templateName.$this->container->get('huh.twig.template.factory')->getTemplateSuffix(),
            $templateName.$this->container->get('huh.twig.template.factory')->getCoreTemplateSuffix(),
            $templateName,
        ];

        $templates = array_intersect($suffixedTemplates, $prefixedTemplates);
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

        try {
            $path = $this->container->get('huh.utils.template')->getTemplate($customTemplateName, 'html.twig');
        } catch (\Exception $e) {
            return false;
        }

        // template not found
        if (!$path) {
            return false;
        }

        /** @var FrontendFrameworkInterface $frontendFramework */
        if (null !== ($layout = $this->getLayout()) && null !== ($frontendFramework = $this->container
                ->get(FrontendFrameworkCollection::class)->getFramework($layout->ttFramework))
        ) {
            $callback = $frontendFramework->prepare(new PrepareTemplateCallback($templateName, $customTemplateName, $path, $data, $layout));
        }

        return [$callback->getCustomTemplateName(), $callback->getData()];
    }

    public function onGetAttributesFromDca(array $attributes, $dc = null): array
    {
        // add format placeholder for accessibility reasons
        if ('text' === $attributes['type'] && isset($attributes['rgxp']) && \in_array($attributes['rgxp'], ['datim', 'date', 'time'])) {
            $attributes['placeholder'] = System::getContainer()->get('translator')->trans('huh.twig.templates.placeholder.'.$attributes['rgxp'], [
                '{format}' => System::getContainer()->get('huh.utils.date')->transformPhpDateFormatToISO8601(Config::get($attributes['rgxp'].'Format')),
            ]);
        }

        return $attributes;
    }

    protected function getLayout()
    {
        if (!$this->layout) {
            global $objPage;

            if (null === $objPage || null === ($this->layout = $this->container
                    ->get('huh.utils.model')
                    ->findModelInstanceByPk('tl_layout', $objPage->layout)
                )) {
                return null;
            }
        }

        return $this->layout;
    }
}
