<?php

/*
 * Copyright (c) 2020 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_HOOKS']['parseTemplate']['twig-templates'] = ['huh.twig.event_listener.hook_listener', 'parseTemplate'];
$GLOBALS['TL_HOOKS']['getAttributesFromDca']['twig-templates'] = [\HeimrichHannot\TwigTemplatesBundle\EventListener\GetAttributesFromDcaListener::class, '__invoke'];

if (is_array($GLOBALS['TL_HOOKS']['parseWidget']) && in_array(['HeimrichHannot\FormHybrid\Hooks', 'parseWidgetHook'], $GLOBALS['TL_HOOKS']['parseWidget'])) {
    array_insert($GLOBALS['TL_HOOKS']['parseWidget'], array_search(['HeimrichHannot\FormHybrid\Hooks', 'parseWidgetHook'], $GLOBALS['TL_HOOKS']['parseWidget']), [
        'twig-templates' => ['huh.twig.event_listener.hook_listener', 'parseWidget'],
    ]);
} else {
    $GLOBALS['TL_HOOKS']['parseWidget']['twig-templates'] = ['huh.twig.event_listener.hook_listener', 'parseWidget'];
}
