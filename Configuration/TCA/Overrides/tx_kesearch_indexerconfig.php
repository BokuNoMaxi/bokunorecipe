<?php
// Add you own indexer to the array, use a comma to join more indexers.

use BokuNo\Bokunorecipe\Indexer\RecipeIndexer;

$GLOBALS["TCA"]["tx_kesearch_indexerconfig"]["columns"]["sysfolder"][
  "displayCond"
] .= "," . RecipeIndexer::KEY;
