<?php

$lang = &$GLOBALS['TL_LANG']['tl_layout'];

/**
 * Fields
 */
$lang['ttUseTwig'][0]                    = 'Use twig templates';
$lang['ttUseTwig'][1]                    = 'Activate to output contao core templates as twig templates.';
$lang['ttFramework'][0]                  = 'Use framework';
$lang['ttFramework'][1]                  = 'Select a framework to replace the default contao templates with those with framework support.';
$lang['ttUseFrameworkCustomControls'][0] = 'Use custom controls';
$lang['ttUseFrameworkCustomControls'][1] = 'Choose this option to enable the usage of custom controls (e.g. checkbox, radio).';

/**
 * Legends
 */
$lang['tt_framework_templates_legend'] = 'Twig templates & frontend framework';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_layout']['references']['ttFramework']['contao'] = 'Contao';
$GLOBALS['TL_LANG']['tl_layout']['references']['ttFramework']['bs4']    = 'Bootstrap 4';