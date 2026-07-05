<?php
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

if (!isset($GLOBALS['TCA']['sys_category']['ctrl']['type'])) {
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['sys_category']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_bokunorecipe_sys_category = [];
    $tempColumnstx_bokunorecipe_sys_category[$GLOBALS['TCA']['sys_category']['ctrl']['type']] = [
        'exclude' => true,
        'label' => 'LLL:EXT:bokunorecipe/Resources/Private/Language/locallang_db.xlf:tx_bokunorecipe.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['Systemcategory', ''],
            ],
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    ExtensionManagementUtility::addTCAcolumns('sys_category', $tempColumnstx_bokunorecipe_sys_category);
}

ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    $GLOBALS['TCA']['sys_category']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['sys_category']['ctrl']['label']
);

// inherit and extend the show items from the parent class
if (isset($GLOBALS['TCA']['sys_category']['types']['1']['showitem'])) {
    $GLOBALS['TCA']['sys_category']['types']['Tx_Bokunorecipe_Category']['showitem'] = $GLOBALS['TCA']['sys_category']['types']['1']['showitem'];
} elseif (is_array($GLOBALS['TCA']['sys_category']['types'])) {
    // use first entry in types array
    $sys_category_type_definition = reset($GLOBALS['TCA']['sys_category']['types']);
    $GLOBALS['TCA']['sys_category']['types']['Tx_Bokunorecipe_Category']['showitem'] = $sys_category_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['sys_category']['types']['Tx_Bokunorecipe_Category']['showitem'] = '';
}

$GLOBALS['TCA']['sys_category']['types']['Tx_Bokunorecipe_Category']['showitem'] .= ',--div--;LLL:EXT:bokunorecipe/Resources/Private/Language/locallang_db.xlf:tx_bokunorecipe_domain_model_category,';
$GLOBALS['TCA']['sys_category']['types']['Tx_Bokunorecipe_Category']['showitem'] .= '';

$GLOBALS['TCA']['sys_category']['columns'][$GLOBALS['TCA']['sys_category']['ctrl']['type']]['config']['items'][] = [
    'LLL:EXT:bokunorecipe/Resources/Private/Language/locallang_db.xlf:sys_category.tx_extbase_type.Tx_Bokunorecipe_Category',
    'Tx_Bokunorecipe_Category'
];
