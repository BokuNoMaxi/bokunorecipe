<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Controller;

use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use BokuNo\Bokunorecipe\Domain\Repository\IngredientsRepository;
use Psr\Http\Message\ResponseInterface;
use BokuNo\Bokunorecipe\Domain\Model\Ingredients;
use TYPO3\CMS\Core\Messaging\AbstractMessage;

/**
 * This file is part of the "BokuNoRecipe" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2021 Markus Ketterer <ketterer.markus@gmx.at>
 */

/**
 * IngredientsController
 */
class IngredientsController extends ActionController
{
    /**
     * ingredientsRepository
     *
     * @var IngredientsRepository
     */
    protected $ingredientsRepository = null;

    /**
     * @param IngredientsRepository $ingredientsRepository
     */
    public function injectIngredientsRepository(
        IngredientsRepository $ingredientsRepository
    ) {
        $this->ingredientsRepository = $ingredientsRepository;
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction()
    {
        $ingredients = $this->ingredientsRepository->findAll();
        $this->view->assign("ingredients", $ingredients);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @param Ingredients $ingredients
     * @return string|object|null|void
     */
    public function showAction(Ingredients $ingredients)
    {
        $this->view->assign("ingredients", $ingredients);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return string|object|null|void
     */
    public function newAction()
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param Ingredients $newIngredients
     * @return string|object|null|void
     */
    public function createAction(Ingredients $newIngredients)
    {
        $this->addFlashMessage(
            "The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html",
            "",
            AbstractMessage::WARNING
        );
        $this->ingredientsRepository->add($newIngredients);
        $this->redirect("list");
    }

    /**
     * action edit
     *
     * @param Ingredients $ingredients
     * @return string|object|null|void
     */
    #[IgnoreValidation(['value' => 'ingredients'])]
    public function editAction(Ingredients $ingredients)
    {
        $this->view->assign("ingredients", $ingredients);
        return $this->htmlResponse();
    }

    /**
     * action update
     *
     * @param Ingredients $ingredients
     * @return string|object|null|void
     */
    public function updateAction(Ingredients $ingredients)
    {
        $this->addFlashMessage(
            "The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html",
            "",
            AbstractMessage::WARNING
        );
        $this->ingredientsRepository->update($ingredients);
        $this->redirect("list");
    }

    /**
     * action delete
     *
     * @param Ingredients $ingredients
     * @return string|object|null|void
     */
    public function deleteAction(Ingredients $ingredients)
    {
        $this->addFlashMessage(
            "The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/p/friendsoftypo3/extension-builder/master/en-us/User/Index.html",
            "",
            AbstractMessage::WARNING
        );
        $this->ingredientsRepository->remove($ingredients);
        $this->redirect("list");
    }
}
