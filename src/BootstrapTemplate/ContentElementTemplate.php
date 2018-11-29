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


use Contao\FrontendTemplate;

class ContentElementTemplate extends DefaultTemplate
{
	const TYPE = "contentelement";

	/**
	 * Prepare templateName and templateData from entity (Widget, Module, ContentElement,...)
	 *
	 * @param FrontendTemplate $entity
	 * @return mixed
	 */
	function prepareData($entity)
	{
		$this->templateName = $entity->getName();
		$this->templateData = $entity->getData();
	}

	public function getType(): string
	{
		return static::TYPE;
	}
}