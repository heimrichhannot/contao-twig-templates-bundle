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
use HeimrichHannot\UtilsBundle\Template\TemplateUtil;

class FormTemplate extends AbstractTemplate
{
	/**
	 * @var ClassUtil
	 */
	protected $classUtil;
	protected $widgetSupportsCustomForms;

	public function __construct(TemplateUtil $templateUtil, ClassUtil $classUtil)
	{
		parent::__construct($templateUtil);
		$this->classUtil = $classUtil;
	}


	public function supportCustomForm()
	{
		if ($this->widgetSupportsCustomForms)
		{
			try {
				$customFormTemplate = $this->templateName.HookListener::CUSTOM_SUFFIX;
				if (\Contao\System::getContainer()->get('huh.utils.template')->getTemplate($customFormTemplate) !== $customFormTemplate)
				{
					$this->templateName = $customFormTemplate;
				}
			} catch (\Exception $e) {
				// if template not found, use default template
			}
		}
	}

	/**
	 * Set the form entity, e.g. Widget, Module,...
	 *
	 * @param Widget $entity
	 * @return mixed
	 * @throws \ReflectionException
	 */
	function setEntity($entity)
	{
		$this->templateName              = $entity->template;
		$this->templateData              = $this->classUtil->jsonSerialize($entity, [], [
			'includeProperties' => true,
			'ignorePropertyVisibility' => true
		]);
		$this->widgetSupportsCustomForms = $entity->addBootstrapCustomControls;
	}
}