<?php
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use BokuNo\Bokunorecipe\Controller\RecipeController;
use BokuNo\Bokunorecipe\Controller\IngredientsController;
use BokuNo\Bokunorecipe\Configuration\KeSearchConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

(static function() {
    ExtensionUtility::configurePlugin(
        'Bokunorecipe',
        'Bokunorecipe',
        [
            RecipeController::class => 'list, show, new, create, edit, update'
        ],
        // non-cacheable actions
        [
            RecipeController::class => 'create, update, delete, ',
            IngredientsController::class => 'create, update, delete'
        ]
    );

    ExtensionUtility::configurePlugin(
        'Bokunorecipe',
        'Bokunocookinghelper',
        [
            RecipeController::class => 'helper'
        ],
        // non-cacheable actions
        [
            RecipeController::class => 'helper'
        ]
    );
})();
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
if (ExtensionManagementUtility::isLoaded('ke_search')) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search'] = KeSearchConfiguration::registerIndexers(
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search'] ?? []
    );
}
