<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Configuration;

final class KeSearchConfiguration
{
    public const RECIPE_INDEXER_KEY = 'tx_bokunorecipe_domain_model_recipe';
    private const RECIPE_INDEXER_CLASS = 'BokuNo\\Bokunorecipe\\Indexer\\RecipeIndexer';

    public static function registerIndexers(array $keSearchConfiguration): array
    {
        $keSearchConfiguration['registerIndexerConfiguration'] ??= [];
        $keSearchConfiguration['customIndexer'] ??= [];
        $keSearchConfiguration['fileReferenceTypes'] ??= [];

        $keSearchConfiguration['registerIndexerConfiguration'][] = self::RECIPE_INDEXER_CLASS;
        $keSearchConfiguration['customIndexer'][] = self::RECIPE_INDEXER_CLASS;
        $keSearchConfiguration['fileReferenceTypes'][self::RECIPE_INDEXER_KEY] = [
            'table' => self::RECIPE_INDEXER_KEY,
            'field' => 'images',
        ];

        return $keSearchConfiguration;
    }

    public static function extendIndexerConfigurationTca(array $tca): array
    {
        if (!isset($tca['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'])) {
            return $tca;
        }

        $tca['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond'] .= ',' . self::RECIPE_INDEXER_KEY;

        return $tca;
    }
}
