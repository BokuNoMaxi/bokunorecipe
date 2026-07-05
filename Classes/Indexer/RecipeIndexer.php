<?php
// Set you own vendor name.
// Adjust the extension name part of the namespace to your extension key.
namespace BokuNo\Bokunorecipe\Indexer;

use Tpwd\KeSearch\Indexer\IndexerBase;
use TYPO3\CMS\Core\Database\Connection;
use Tpwd\KeSearch\Indexer\IndexerRunner;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

// Set you own class name.
class RecipeIndexer extends IndexerBase
{
    // Set a key for your indexer configuration.
    // Add this key to the $GLOBALS[...] array in Configuration/TCA/Overrides/tx_kesearch_indexerconfig.php, too!
    // It is recommended (but no must) to use the name of the table you are going to index as a key because this
    // gives you the "original row" to work with in the result list template.
    const KEY = "tx_bokunorecipe_domain_model_recipe";

    const TABLE = "tx_bokunorecipe_domain_model_recipe";

    /**
     * Adds the custom indexer to the TCA of indexer configurations, so that
     * it's selectable in the backend as an indexer type, when you create a
     * new indexer configuration.
     *
     * @param array $params
     * @param object $pObj
     */
    public function registerIndexerConfiguration(&$params, $pObj)
    {
        // Set a name and an icon for your indexer.
        $customIndexer = [
            "[CUSTOM] Recipe Indexer (ext:bokunorecipes)",
            RecipeIndexer::KEY,
            "EXT:bokunorecipe/indexer-icon.gif",
        ];
        $params["items"][] = $customIndexer;
    }

    /**
     * Custom indexer for ke_search.
     *
     * @param   array $indexerConfig Configuration from TYPO3 Backend.
     * @param   IndexerRunner $indexerObject Reference to indexer class.
     * @return  string Message containing indexed elements.
     */
    public function customIndexer(
        array &$indexerConfig,
        IndexerRunner &$indexerObject
    ): string {
        if ($indexerConfig["type"] == RecipeIndexer::KEY) {
            $table = RecipeIndexer::TABLE;
            // Doctrine DBAL using Connection Pool.
            /** @var Connection $connection */
            $connection = GeneralUtility::makeInstance(
                ConnectionPool::class
            )->getConnectionForTable($table);
            $queryBuilder = $connection->createQueryBuilder();
            // Handle restrictions.
            // Don't fetch hidden or deleted elements, but the elements
            // with frontend user group access restrictions or time (start / stop)
            // restrictions in order to copy those restrictions to the index.
            $queryBuilder
                ->getRestrictions()
                ->removeAll()
                ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
                ->add(GeneralUtility::makeInstance(HiddenRestriction::class));

            $items = $queryBuilder
                ->select("*")
                ->distinct()
                ->from($table)->where($queryBuilder
                ->expr()
                ->in("pid", $indexerConfig["sysfolder"]))->executeQuery();

            // Loop through the records and write them to the index.
            $counter = 0;
            while ($record = $items->fetchAssociative()) {
                // Compile the information, which should go into the index.
                // The field names depend on the table you want to index!
                $title = strip_tags($record["title"]);
                $abstract = "";
                $content = strip_tags($record["teaser"]);

                $fullContent = $title . "\n" . $content;
                $tags = "";
                $params =
                    "&tx_bokunorecipe_bokunorecipe[recipe]=" .
                    $record["uid"] .
                    "&tx_bokunorecipe_bokunorecipe[controller]=Recipe&tx_bokunorecipe_bokunorecipe[action]=show";

                $additionalFields = [
                    "orig_uid" => $record["uid"],
                    "orig_pid" => $record["pid"],
                    "sortdate" => $record["tstamp"],
                ];

                // ... and store the information in the index
                $result = $indexerObject->storeInIndex(
                    $indexerConfig["storagepid"], // storage PID
                    $title, // record title
                    RecipeIndexer::KEY, // content type
                    $indexerConfig["targetpid"], // target PID: where is the single view?
                    $fullContent, // indexed content, includes the title (linebreak after title)
                    $tags, // tags for faceted search
                    $params, // typolink params for singleview
                    $abstract, // abstract; shown in result list if not empty
                    $record["sys_language_uid"], // language uid
                    $record["starttime"], // starttime
                    $record["endtime"], // endtime
                    $record["fe_group"], // fe_group
                    false, // debug only?
                    $additionalFields // additionalFields
                );
                $counter++;
            }

            return $counter . " Recipes have been indexed.";
        }

        return "";
    }
}
