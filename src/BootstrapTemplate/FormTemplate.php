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
use HeimrichHannot\BootstrapTemplatesBundle\EventListener\HookListener;
use HeimrichHannot\UtilsBundle\Classes\ClassUtil;

class FormTemplate extends AbstractTemplate
{
	const TYPE = "widget";

	/**
	 * @var ClassUtil
	 */
	protected $classUtil;
	protected $widgetSupportsCustomForms;

	/**
	 * @param ClassUtil $classUtil
	 */
	public function setClassUtil(ClassUtil $classUtil): void
	{
		$this->classUtil = $classUtil;
	}

	public function supportCustomForm()
	{
		if ($this->widgetSupportsCustomForms)
		{
			try {
				$customFormTemplate = $this->templateName.HookListener::CUSTOM_SUFFIX;
				if ($this->templateUtil->getTemplate($customFormTemplate) !== $customFormTemplate)
				{
					$this->templateName = $customFormTemplate;
				}
			} catch (\Exception $e) {
				// if template not found, use default template
			}
		}
	}

	function prepareData($entity)
	{
		$this->templateName              = $entity->template;
		$this->templateData              = $this->classUtil->jsonSerialize($entity, [], [
			'includeProperties' => true,
			'ignorePropertyVisibility' => true
		]);
		$this->widgetSupportsCustomForms = $entity->addBootstrapCustomControls;
	}

	public function getType(): string
	{
		return static::TYPE;
	}
}