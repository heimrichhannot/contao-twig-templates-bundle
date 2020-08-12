<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use Contao\Input;
use Contao\LayoutModel;
use Contao\Template;
use Contao\Widget;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderTwigTemplateEvent;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\ContaoFramework;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkInterface;
use HeimrichHannot\TwigTemplatesBundle\Twig\TemplateFactory;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Container\ContainerUtil;
use HeimrichHannot\UtilsBundle\Model\ModelUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RenderListener
{
    const TWIG_TEMPLATE = 'twig_template';
    const TWIG_CONTEXT = 'twig_context';

    /**
     * @var ContainerUtil
     */
    protected $containerUtil;

    /**
     * @var LayoutModel|null
     */
    protected $layout;
    /**
     * @var TemplateUtil
     */
    protected $templateUtil;
    /**
     * @var array|null
     */
    protected $templatesNames;
    /**
     * @var FrontendFrameworkCollection
     */
    protected $frontendFrameworkCollection;
    /**
     * @var bool
     */
    protected $terminationCondition;
    /**
     * @var FrontendFrameworkInterface
     */
    protected $frontendFramework;
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;
    /**
     * @var TemplateFactory
     */
    protected $templateFactory;
    /**
     * @var ClassUtil
     */
    protected $classUtil;
    /**
     * @var ModelUtil
     */
    protected $modelUtil;

    /**
     * RenderListener constructor.
     */
    public function __construct(ContainerUtil $containerUtil, TemplateUtil $templateUtil, FrontendFrameworkCollection $frontendFrameworkCollection, EventDispatcherInterface $eventDispatcher, TemplateFactory $templateFactory, ClassUtil $classUtil, ModelUtil $modelUtil)
    {
        $this->containerUtil = $containerUtil;
        $this->templateUtil = $templateUtil;
        $this->frontendFrameworkCollection = $frontendFrameworkCollection;
        $this->eventDispatcher = $eventDispatcher;
        $this->templateFactory = $templateFactory;
        $this->classUtil = $classUtil;
        $this->modelUtil = $modelUtil;
    }

    /**
     * @Hook("parseTemplate")
     */
    public function onParseTemplate(Template $template): void
    {
        $layout = $this->getLayout();

        if ($this->isTerminationCondition($layout)) {
            return;
        }
        $result = $this->applyTwigTemplate($template->getName(), $template->getData());

        if (false === $result) {
            return;
        }

        $template->setName('twig_template_proxy');

        [$templateName, $templateData] = $result;

        $template->setData([
            static::TWIG_TEMPLATE => $templateName,
            static::TWIG_CONTEXT => $templateData,
        ]);
    }

    /**
     * @Hook("parseWidget")
     */
    public function onParseWidget(string $buffer, Widget $widget): string
    {
        $layout = $this->getLayout();

        if ($this->isTerminationCondition($layout)) {
            return $buffer;
        }

        $data = $this->classUtil->jsonSerialize(
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

        [$templateName, $templateData] = $result;

        $widget->{static::TWIG_TEMPLATE} = $templateName;
        $widget->{static::TWIG_CONTEXT} = $templateData;

        $widget->template = 'twig_template_proxy';

        return $widget->inherit();
    }

    /**
     * Render the template.
     *
     * @param $contaoTemplate
     */
    public function render($contaoTemplate)
    {
        $layout = $this->getLayout();
        $frontendFramework = $this->getFrontendFramework($layout);

        if ($contaoTemplate instanceof Widget) {
            $data = $this->prepareWidget($contaoTemplate);
            $twigTemplateName = $data['arrConfiguration'][self::TWIG_TEMPLATE] ?? null;
            $twigTemplateContext = $data ?? null;
        } else {
            $data = $contaoTemplate->getData();
            $twigTemplateName = $data[self::TWIG_TEMPLATE] ?? null;
            $twigTemplateContext = $data[self::TWIG_CONTEXT] ?? null;
        }

        $legacyTemplate = $this->templateFactory->createInstance($contaoTemplate);

        $callback = $frontendFramework->beforeRender(new BeforeRenderCallback($twigTemplateName, $twigTemplateContext, $contaoTemplate, $legacyTemplate));

        /** @var BeforeRenderTwigTemplateEvent $event */
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        /** @noinspection PhpParamsInspection */
        $event = $this->eventDispatcher->dispatch(
            BeforeRenderTwigTemplateEvent::NAME,
            new BeforeRenderTwigTemplateEvent(
                $legacyTemplate->getType(),
                $callback->getTwigTemplateName(),
                $callback->getTwigTemplateContext(),
                $contaoTemplate
            )
        );

        if ($contaoTemplate instanceof Template) {
            $contaoTemplate->setData($event->getTemplateData());
        }

        $buffer = $this->templateUtil->renderTwigTemplate($event->getTemplateName(), $event->getTemplateData());

        return $buffer;
    }

    protected function prepareWidget($entity): array
    {
        $templateData = $this->classUtil->jsonSerialize(
            $entity,
            [],
            [
                'includeProperties' => true,
                'ignorePropertyVisibility' => true,
            ]
        );

        if (method_exists($entity, 'getOptions')) {
            $templateData['arrOptions'] = $this->classUtil->callInaccessibleMethod($entity, 'getOptions');
        }

        return $templateData;
    }

    protected function isTerminationCondition(?LayoutModel $layoutModel): bool
    {
        if (\is_bool($this->terminationCondition)) {
            return $this->terminationCondition;
        }
        $this->terminationCondition = false;

        if (!$this->containerUtil->isFrontend()) {
            $this->terminationCondition = true;
        }
        // deactivate if AMP mode is active
        if (class_exists("HeimrichHannot\AmpBundle\HeimrichHannotContaoAmpBundle") && Input::get('amp')) {
            $this->terminationCondition = true;
        }

        if (!$layoutModel || !$layoutModel->ttUseTwig) {
            $this->terminationCondition = true;
        }

        return $this->terminationCondition;
    }

    protected function getLayout()
    {
        if (!$this->layout) {
            global $objPage;

            if (null === $objPage || null === ($this->layout = $this->modelUtil
                    ->findModelInstanceByPk('tl_layout', $objPage->layout)
                )) {
                return null;
            }
        }

        return $this->layout;
    }

    protected function getTemplateNames(): array
    {
        if (!$this->templatesNames) {
            try {
                $this->templatesNames = array_keys($this->templateUtil->getAllTemplates());
            } catch (\Exception $e) {
                $this->templatesNames = [];
            }
        }

        return $this->templatesNames;
    }

    protected function getFrontendFramework(LayoutModel $layoutModel): ?FrontendFrameworkInterface
    {
        if (!$this->frontendFramework) {
            if ($layoutModel->ttFramework) {
                $this->frontendFramework = $this->frontendFrameworkCollection->getFramework($layoutModel->ttFramework);
            } else {
                $this->frontendFramework = $this->frontendFrameworkCollection->getFramework(ContaoFramework::getIdentifier());
            }
        }

        return $this->frontendFramework;
    }

    /**
     * Applies twig template.
     *
     * @param string $templateName Template name
     * @param array  $data         Template data
     *
     * @return array|bool
     */
    protected function applyTwigTemplate(string $templateName, array $data)
    {
        $path = null;

        if (!$layout = $this->getLayout()) {
            return false;
        }

        $frontendFramework = $this->getFrontendFramework($layout);

        $suffixedTemplates = [
            $templateName.'_'.$frontendFramework::getIdentifier(),
            $templateName,
        ];

        $templates = array_intersect($suffixedTemplates, $this->getTemplateNames());
        $customTemplateName = reset($templates);

        if (!$customTemplateName) {
            return false;
        }

        try {
            $path = $this->templateUtil->getTemplate($customTemplateName, 'html.twig');
        } catch (\Exception $e) {
            return false;
        }

        // template not found
        if (!$path) {
            return false;
        }

        $callback = $frontendFramework->prepare(new PrepareTemplateCallback($templateName, $customTemplateName, $path, $data));

        return [$callback->getCustomTemplateName(), $callback->getData()];
    }
}
