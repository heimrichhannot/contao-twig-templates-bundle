<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate']['twig-templates']    = ['huh.twig.event_listener.hook_listener', 'parseTemplate'];
$GLOBALS['TL_HOOKS']['parseWidget']['twig-templates']      = ['huh.twig.event_listener.hook_listener', 'parseWidget'];
