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


use Contao\Widget;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;

class TemplateFactory
{
	/**
	 * @var TemplateUtil
	 */
	private $templateUtil;
	/**
	 * @var ClassUtil
	 */
	private $classUtil;

	public function __construct(TemplateUtil $templateUtil, ClassUtil $classUtil)
	{
		$this->templateUtil = $templateUtil;
		$this->classUtil = $classUtil;
	}


	public function createInstance($object)
	{
		if ($object instanceof Widget)
		{
			$template = new FormTemplate($this->templateUtil, $this->classUtil);
		}

		if (!$template)
		{
			return null;
		}

		$template->setEntity($object);
		return $template;
	}
}