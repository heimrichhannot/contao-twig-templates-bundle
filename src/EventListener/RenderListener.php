<?php

/*
 * Copyright (c) 2022 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\TwigTemplatesBundle\EventListener;

use Contao\Input;
use Contao\LayoutModel;
use HeimrichHannot\TwigSupportBundle\Event\BeforeParseTwigTemplateEvent;
use HeimrichHannot\TwigSupportBundle\Event\BeforeRenderTwigTemplateEvent;
use HeimrichHannot\TwigSupportBundle\Exception\TemplateNotFoundException;
use HeimrichHannot\TwigSupportBundle\Filesystem\TwigTemplateLocator;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderCallback;
use HeimrichHannot\TwigTemplatesBundle\Event\BeforeRenderTwigTemplateEvent as OnBeforeRenderTwigTemplateEvent;
use HeimrichHannot\TwigTemplatesBundle\Event\PrepareTemplateCallback;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\ContaoFramework;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkCollection;
use HeimrichHannot\TwigTemplatesBundle\FrontendFramework\FrontendFrameworkInterface;
use HeimrichHannot\UtilsBundle\Util\Utils;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RenderListener
{
    const TWIG_TEMPLATE = 'twig_template';
    const TWIG_CONTEXT = 'twig_context';

    /**
     * @var LayoutModel|null
     */
    protected $layout;
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
     * @var TwigTemplateLocator
     */
    protected $templateLocator;
    /** @var Utils */
    private $utils;

    /**
     * RenderListener constructor.
     */
    public function __construct(FrontendFrameworkCollection $frontendFrameworkCollection, EventDispatcherInterface $eventDispatcher, TwigTemplateLocator $templateLocator, Utils $utils)
    {
        $this->frontendFrameworkCollection = $frontendFrameworkCollection;
        $this->eventDispatcher = $eventDispatcher;
        $this->templateLocator = $templateLocator;
        $this->utils = $utils;
    }

    public function onBeforeParseTwigTemplateEvent(BeforeParseTwigTemplateEvent $event)
    {
        $layout = $this->getLayout();

        if ($this->isTerminationCondition($layout)) {
            return;
        }
        [$templateName, $templateData] = $this->applyTwigTemplate($event->getTemplateName(), $event->getTemplateData());

        $event->setTemplateName($templateName);
        $event->setTemplateData($templateData);
    }

    public function onBeforeRenderTwigTemplateEvent(BeforeRenderTwigTemplateEvent $event)
    {
        $layout = $this->getLayout();

        if ($this->isTerminationCondition($layout)) {
            return;
        }

        $data = $event->getTemplateData();
        $data['_entity'] = $event->getContaoTemplate();

        $frontendFramework = $this->getFrontendFramework($layout);

        $callback = $frontendFramework->beforeRender(
            new BeforeRenderCallback($event->getTemplateName(), $data, $event->getContaoTemplate(), $layout)
        );

        /** @var BeforeRenderTwigTemplateEvent $event */
        $beforeEvent = $this->eventDispatcher->dispatch(
            new OnBeforeRenderTwigTemplateEvent(
                $callback->getTwigTemplateName(),
                $callback->getTwigTemplateContext(),
                $event->getContaoTemplate()
            ),
            OnBeforeRenderTwigTemplateEvent::NAME
        );

        if ($event->getTemplateName() !== $beforeEvent->getTemplateName()) {
            try {
                $event->setTwigTemplatePath($this->templateLocator->getTemplatePath($beforeEvent->getTemplateName()));
            } catch (TemplateNotFoundException $e) {
            }
        }
        $event->setTemplateData($beforeEvent->getTemplateData());
    }

    protected function isTerminationCondition(?LayoutModel $layoutModel): bool
    {
        if (\is_bool($this->terminationCondition)) {
            return $this->terminationCondition;
        }
        $this->terminationCondition = false;

        if (!$this->utils->container()->isFrontend()) {
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
            $objPage = $this->utils->request()->getCurrentPageModel();

            if (null === $objPage || null === ($this->layout = LayoutModel::findByPk($objPage->layout))) {
                return null;
            }
        }

        return $this->layout;
    }

    protected function getTemplateNames(): array
    {
        if (!$this->templatesNames) {
            try {
                $this->templatesNames = array_keys($this->templateLocator->getTemplates());
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
            $path = $this->templateLocator->getTemplatePath($customTemplateName);
        } catch (TemplateNotFoundException $e) {
            return false;
        }

        $callback = $frontendFramework->prepare(new PrepareTemplateCallback($templateName, $customTemplateName, $path, $data, $layout));

        return [$callback->getCustomTemplateName(), $callback->getData()];
    }
}
