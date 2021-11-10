<?php

declare(strict_types=1);

namespace BokuNoRecipe\Bokunorecipe\Controller;


/**
 * This file is part of the "BokuNoRecipe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 Markus Ketterer <ketterer.markus@gmx.at>
 */

/**
 * RecipeController
 */
class RecipeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * recipeRepository
     *
     * @var \BokuNoRecipe\Bokunorecipe\Domain\Repository\RecipeRepository
     */
    protected $recipeRepository = null;

    /**
     * @param \BokuNoRecipe\Bokunorecipe\Domain\Repository\RecipeRepository $recipeRepository
     */
    public function injectRecipeRepository(\BokuNoRecipe\Bokunorecipe\Domain\Repository\RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $recipes = $this->recipeRepository->findAll();
        $this->view->assign('recipes', $recipes);
    }

    /**
     * action show
     *
     * @param \BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe
     * @return string|object|null|void
     */
    public function showAction(\BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe)
    {
        $this->view->assign('recipe', $recipe);
    }

    /**
     * action new
     *
     * @return string|object|null|void
     */
    public function newAction()
    {
    }

    /**
     * action create
     *
     * @param \BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $newRecipe
     * @return string|object|null|void
     */
    public function createAction(\BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $newRecipe)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->recipeRepository->add($newRecipe);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("recipe")
     * @return string|object|null|void
     */
    public function editAction(\BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe)
    {
        $this->view->assign('recipe', $recipe);
    }

    /**
     * action update
     *
     * @param \BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe
     * @return string|object|null|void
     */
    public function updateAction(\BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->recipeRepository->update($recipe);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe
     * @return string|object|null|void
     */
    public function deleteAction(\BokuNoRecipe\Bokunorecipe\Domain\Model\Recipe $recipe)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->recipeRepository->remove($recipe);
        $this->redirect('list');
    }
}
