<?php
defined('TYPO3') || die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::registerPlugin(
    'Bokunorecipe',
    'Bokunorecipe',
    'bokunorecipe',
    null,
    'plugins',
    '',
    'FILE:EXT:bokunorecipe/Configuration/FlexForms/Default.xml'
);

ExtensionUtility::registerPlugin(
    'Bokunorecipe',
    'Bokunocookinghelper',
    'bokunocookinghelper'
);
