<?php

declare(strict_types=1);

use BokuNo\Bokunorecipe\Domain\Model\Category;

return [
    Category::class => [
        'tableName' => 'sys_category',
        'recordType' => 'Tx_Bokunorecipe_Category'
    ],
];
