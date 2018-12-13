<?php

$dca = &$GLOBALS['TL_DCA']['tl_layout'];

/**
 * Palettes
 */
$dca['palettes']['__selector__'][] = 'frameworkTemplate';

$dca['palettes']['default'] = str_replace('{sections_legend', '{framework_templates_legend},frameworkTemplate;{sections_legend', $dca['palettes']['default']);

/**
 * Subpalettes
 */
$dca['subpalettes']['frameworkTemplate_bs4'] = 'useFrameworkCustomControls';

/**
 * Fields
 */
$fields = [
    'frameworkTemplate'          => [
        'label'     => &$GLOBALS['TL_LANG']['tl_layout']['frameworkTemplateSuffix'],
        'exclude'   => true,
        'inputType' => 'select',
        'options'   => ['bs4'],
        'reference' => $GLOBALS['TL_LANG']['tl_layout']['references']['frameworkTemplate'],
        'eval'      => ['includeBlankOption' => true, 'submitOnChange' => true],
        'sql'       => "varchar(64) NOT NULL default ''",
    ],
    'useFrameworkCustomControls' => [
        'label'     => &$GLOBALS['TL_LANG']['tl_layout']['useFrameworkCustomControls'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
];

$dca['fields'] += $fields;