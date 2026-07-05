<?php

defined('TYPO3') || die();

use BokuNo\Bokunorecipe\Configuration\KeSearchConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (ExtensionManagementUtility::isLoaded('ke_search')) {
    $GLOBALS['TCA'] = KeSearchConfiguration::extendIndexerConfigurationTca($GLOBALS['TCA']);
}
