<?php

$lang = &$GLOBALS['TL_LANG']['tl_layout'];

/**
 * Fields
 */
$lang['ttUseTwig'][0]                    = 'Twig Templates verwenden';
$lang['ttUseTwig'][1]                    = 'Aktivieren um Contao Core Templates als Twig-Templates auszugeben.';
$lang['ttFramework'][0]                  = 'Framework verwenden';
$lang['ttFramework'][1]                  =
    'Wählen Sie ein Framework aus, um die Standard-Contao-Templates durch solche mit Framework-Unterstützung ersetzen möchten.';
$lang['ttUseFrameworkCustomControls'][0] = 'Custom Controls verwenden';
$lang['ttUseFrameworkCustomControls'][1] = 'Wählen Sie diese Option, wenn Sie vom Framework Custom Controls (Checkbox, Radio…) aktivieren möchten.';

/**
 * Legends
 */
$lang['tt_framework_templates_legend'] = 'Twig Templates & Frontend Framework';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_layout']['references']['ttFramework']['contao'] = 'Contao';
$GLOBALS['TL_LANG']['tl_layout']['references']['ttFramework']['bs4']    = 'Bootstrap 4';
