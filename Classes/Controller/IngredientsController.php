<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Controller;

use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use BokuNo\Bokunorecipe\Domain\Repository\IngredientsRepository;
use Psr\Http\Message\ResponseInterface;
use BokuNo\Bokunorecipe\Domain\Model\Ingredients;

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
    protected $ingredientsRepository;

    public function __construct(IngredientsRepository $ingredientsRepository)
    {
        $this->ingredientsRepository = $ingredientsRepository;
    }

    /**
     * action list
     *
     * @return string|object|null|void
     */
    public function listAction(): ResponseInterface
    {
        $ingredients = $this->ingredientsRepository->findAll();
        $this->view->assign("ingredients", $ingredients);
        return $this->htmlResponse();
    }

    /**
     * action show
     *
     * @return string|object|null|void
     */
    public function showAction(Ingredients $ingredients): ResponseInterface
    {
        $this->view->assign("ingredients", $ingredients);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return string|object|null|void
     */
    public function newAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    /**
     * action create
     */
    public function createAction(Ingredients $newIngredients): ResponseInterface
    {
        $this->ingredientsRepository->add($newIngredients);
        return $this->redirect('list');
    }

    /**
     * action edit
     *
     * @return string|object|null|void
     */
    #[IgnoreValidation(['value' => 'ingredients'])]
    public function editAction(Ingredients $ingredients): ResponseInterface
    {
        $this->view->assign("ingredients", $ingredients);
        return $this->htmlResponse();
    }

    /**
     * action update
     */
    public function updateAction(Ingredients $ingredients): ResponseInterface
    {
        $this->ingredientsRepository->update($ingredients);
        return $this->redirect('list');
    }

    /**
     * action delete
     */
    public function deleteAction(Ingredients $ingredients): ResponseInterface
    {
        $this->ingredientsRepository->remove($ingredients);
        return $this->redirect('list');
    }
}
