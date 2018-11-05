<?php

$dca = &$GLOBALS['TL_DCA']['tl_layout'];

/**
 * Palettes
 */
$dca['palettes']['__selector__'][] = 'addBootstrapTemplates';

$dca['palettes']['default'] = str_replace('{sections_legend', '{bootstrap_templates_legend},addBootstrapTemplates;{sections_legend', $dca['palettes']['default']);

/**
 * Subpalettes
 */
$dca['subpalettes']['addBootstrapTemplates'] = 'addBootstrapCustomControls';

/**
 * Fields
 */
$fields = [
    'addBootstrapTemplates'               => [
        'label'     => &$GLOBALS['TL_LANG']['tl_layout']['addBootstrapTemplates'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''"
    ],
    'addBootstrapCustomControls' => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['addBootstrapCustomControls'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => ['tl_class' => 'w50'],
        'sql'                     => "char(1) NOT NULL default ''"
    ],
];

$dca['fields'] += $fields;