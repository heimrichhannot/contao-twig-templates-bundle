<?php

$dca = &$GLOBALS['TL_DCA']['tl_layout'];

/**
 * Palettes
 */
$dca['palettes']['__selector__'][] = 'ttFramework';

$dca['palettes']['default'] = str_replace('{sections_legend', '{tt_framework_templates_legend},ttUseTwig,ttFramework;{sections_legend', $dca['palettes']['default']);

/**
 * Subpalettes
 */
$dca['subpalettes']['ttFramework_bs4'] = 'ttUseFrameworkCustomControls';

/**
 * Fields
 */
$fields = [
    'ttUseTwig' => [
        'label'     => &$GLOBALS['TL_LANG']['tl_layout']['ttUseTwig'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'ttFramework'          => [
        'label'     => &$GLOBALS['TL_LANG']['tl_layout']['ttFramework'],
        'exclude'   => true,
        'inputType' => 'select',
        'options_callback' => ['huh.twig.templates.data_containers.layout_container','getFrameworkOptions'],
        'reference' => \Contao\System::getContainer()->get('huh.twig.templates.data_containers.layout_container')->getFrameworkNameReference(),
        'eval'      => ['includeBlankOption' => true, 'submitOnChange' => true, 'tl_class' => 'w50 clr'],
        'sql'       => "varchar(64) NOT NULL default ''",
    ],
    'ttUseFrameworkCustomControls' => [
        'label'     => &$GLOBALS['TL_LANG']['tl_layout']['ttUseFrameworkCustomControls'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
];

$dca['fields'] += $fields;