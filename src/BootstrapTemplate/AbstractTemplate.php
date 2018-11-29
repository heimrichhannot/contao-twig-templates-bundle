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


use HeimrichHannot\UtilsBundle\Template\TemplateUtil;

abstract class AbstractTemplate
{
	/**
	 * @var TemplateUtil
	 */
	private $templateUtil;

	protected $templateName;
	protected $templateData;


	/**
	 * AbstractTemplate constructor.
	 */
	public function __construct(TemplateUtil $templateUtil)
	{
		$this->templateUtil = $templateUtil;
	}

	/**
	 * Set the form entity, e.g. Widget, Module,...
	 * Should be used to fill $this->templateName and $this->templateData
	 *
	 *
	 * @param $entity
	 * @return mixed
	 */
	abstract function setEntity($entity);

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
		return $this->templateUtil->renderTwigTemplate($this->templateName, $this->templateData);
	}
}