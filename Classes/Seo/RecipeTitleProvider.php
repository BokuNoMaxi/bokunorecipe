<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Seo;

/**
 * This file is part of the "BokuNoRecipe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

/**
 * Renders the recipe title as the page <title> instead of the generic
 * detail page title - otherwise every recipe URL indexes as "Rezept" in
 * indexed_search since they all share the same page record.
 */
class RecipeTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
