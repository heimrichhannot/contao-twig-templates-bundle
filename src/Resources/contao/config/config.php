<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_HOOKS']['parseTemplate']['twig-templates'] = [\HeimrichHannot\TwigTemplatesBundle\EventListener\RenderListener::class, 'onParseTemplate'];
$GLOBALS['TL_HOOKS']['parseWidget']['twig-templates'] = [\HeimrichHannot\TwigTemplatesBundle\EventListener\RenderListener::class, 'onParseWidget'];
$GLOBALS['TL_HOOKS']['getAttributesFromDca']['twig-templates'] = [\HeimrichHannot\TwigTemplatesBundle\EventListener\GetAttributesFromDcaListener::class, '__invoke'];
