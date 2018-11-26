<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate']['bootstrap-templates'] = ['huh.bootstrap_templates.event_listener.hook_listener', 'parseTemplate'];
$GLOBALS['TL_HOOKS']['parseWidget']['bootstrap-templates'] = ['huh.bootstrap_templates.event_listener.hook_listener', 'parseWidget'];