<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate']['twig-templates']    = ['huh.twig.event_listener.hook_listener', 'parseTemplate'];

if (is_array($GLOBALS['TL_HOOKS']['parseWidget']) && in_array(['HeimrichHannot\FormHybrid\Hooks', 'parseWidgetHook'], $GLOBALS['TL_HOOKS']['parseWidget'])) {
    array_insert($GLOBALS['TL_HOOKS']['parseWidget'], array_search(['HeimrichHannot\FormHybrid\Hooks', 'parseWidgetHook'], $GLOBALS['TL_HOOKS']['parseWidget']), [
        'twig-templates' => ['huh.twig.event_listener.hook_listener', 'parseWidget']
    ]);
} else {
    $GLOBALS['TL_HOOKS']['parseWidget']['twig-templates']    = ['huh.twig.event_listener.hook_listener', 'parseWidget'];
}
echo 1;