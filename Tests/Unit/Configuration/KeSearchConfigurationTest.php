<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Tests\Unit\Configuration;

use BokuNo\Bokunorecipe\Configuration\KeSearchConfiguration;
use PHPUnit\Framework\TestCase;

final class KeSearchConfigurationTest extends TestCase
{
    public function testRegisterIndexersAddsIndexerConfiguration(): void
    {
        $configuration = KeSearchConfiguration::registerIndexers([]);

        self::assertSame(
            ['BokuNo\\Bokunorecipe\\Indexer\\RecipeIndexer'],
            $configuration['registerIndexerConfiguration']
        );
        self::assertSame(
            ['BokuNo\\Bokunorecipe\\Indexer\\RecipeIndexer'],
            $configuration['customIndexer']
        );
        self::assertSame(
            [
                'table' => 'tx_bokunorecipe_domain_model_recipe',
                'field' => 'images',
            ],
            $configuration['fileReferenceTypes'][KeSearchConfiguration::RECIPE_INDEXER_KEY]
        );
    }

    public function testRegisterIndexersPreservesExistingEntries(): void
    {
        $configuration = KeSearchConfiguration::registerIndexers([
            'registerIndexerConfiguration' => ['ExistingIndexer'],
            'customIndexer' => ['ExistingCustomIndexer'],
        ]);

        self::assertSame(
            ['ExistingIndexer', 'BokuNo\\Bokunorecipe\\Indexer\\RecipeIndexer'],
            $configuration['registerIndexerConfiguration']
        );
        self::assertSame(
            ['ExistingCustomIndexer', 'BokuNo\\Bokunorecipe\\Indexer\\RecipeIndexer'],
            $configuration['customIndexer']
        );
    }

    public function testExtendIndexerConfigurationTcaAppendsDisplayCondition(): void
    {
        $tca = [
            'tx_kesearch_indexerconfig' => [
                'columns' => [
                    'sysfolder' => [
                        'displayCond' => 'FIELD:type:IN:default',
                    ],
                ],
            ],
        ];

        $updatedTca = KeSearchConfiguration::extendIndexerConfigurationTca($tca);

        self::assertSame(
            'FIELD:type:IN:default,' . KeSearchConfiguration::RECIPE_INDEXER_KEY,
            $updatedTca['tx_kesearch_indexerconfig']['columns']['sysfolder']['displayCond']
        );
    }

    public function testExtendIndexerConfigurationTcaLeavesUnrelatedTcaUntouched(): void
    {
        $tca = [
            'tt_content' => [
                'columns' => [],
            ],
        ];

        self::assertSame($tca, KeSearchConfiguration::extendIndexerConfigurationTca($tca));
    }
}
