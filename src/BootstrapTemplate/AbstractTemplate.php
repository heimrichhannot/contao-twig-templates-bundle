<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2018 Heimrich & Hannot GmbH
 *
 * @author  Thomas Körner <t.koerner@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


namespace HeimrichHannot\BootstrapTemplatesBundle\BootstrapTemplate;


use HeimrichHannot\BootstrapTemplatesBundle\Event\BeforeRenderEvent;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractTemplate
{
	protected $templateName;
	protected $templateData;
	protected $entity;

	/**
	 * @var TemplateUtil
	 */
	protected $templateUtil;
	/**
	 * @var EventDispatcherInterface
	 */
	protected $eventDispatcher;


	/**
	 * AbstractTemplate constructor.
	 */
	public function __construct(TemplateUtil $templateUtil, EventDispatcherInterface $eventDispatcher)
	{
		$this->templateUtil = $templateUtil;
		$this->eventDispatcher = $eventDispatcher;
	}

	abstract public function getType(): string;

	/**
	 * Set the form entity, e.g. Widget, Module,...
	 *
	 *
	 * @param $entity
	 */
	public function setEntity($entity)
	{
		$this->prepareData($entity);
		$this->entity = $entity;
	}

	/**
	 * Prepare templateName and templateData from entity (Widget, Module, ContentElement,...)
	 *
	 * @param $entity
	 * @return mixed
	 */
	abstract protected function prepareData($entity);

	/**
	 * Render the widget
	 *
	 * Uses $this->templateName and $this->templateData
	 *
	 * @return string
	 * @throws \Psr\Cache\InvalidArgumentException
	 * @throws \Twig_Error_Loader
	 * @throws \Twig_Error_Runtime
	 * @throws \Twig_Error_Syntax
	 */
	public function render()
	{
		$event = $this->eventDispatcher->dispatch(
			BeforeRenderEvent::NAME,
			new BeforeRenderEvent($this->getType(), $this->templateName, $this->templateData, $this->entity)
		);
		return $this->templateUtil->renderTwigTemplate($event->getTemplateName(), $event->getTemplateData());
	}
}