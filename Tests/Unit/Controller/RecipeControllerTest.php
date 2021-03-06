<?php
declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Tests\Unit\Controller;

use BokuNo\Bokunorecipe\Controller\RecipeController;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use BokuNo\Bokunorecipe\Domain\Repository\RecipeRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use BokuNo\Bokunorecipe\Domain\Model\Recipe;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Markus Ketterer <ketterer.markus@gmx.at>
 */
class RecipeControllerTest extends UnitTestCase
{
    /**
     * @var \BokuNo\Bokunorecipe\Controller\RecipeController
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(RecipeController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllRecipesFromRepositoryAndAssignsThemToView()
    {
        $allRecipes = $this->getMockBuilder(ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $recipeRepository = $this->getMockBuilder(RecipeRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $recipeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allRecipes));
        $this->inject($this->subject, 'recipeRepository', $recipeRepository);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('recipes', $allRecipes);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenRecipeToView()
    {
        $recipe = new Recipe();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('recipe', $recipe);

        $this->subject->showAction($recipe);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenRecipeToRecipeRepository()
    {
        $recipe = new Recipe();

        $recipeRepository = $this->getMockBuilder(RecipeRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $recipeRepository->expects(self::once())->method('add')->with($recipe);
        $this->inject($this->subject, 'recipeRepository', $recipeRepository);

        $this->subject->createAction($recipe);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenRecipeToView()
    {
        $recipe = new Recipe();

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('recipe', $recipe);

        $this->subject->editAction($recipe);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenRecipeInRecipeRepository()
    {
        $recipe = new Recipe();

        $recipeRepository = $this->getMockBuilder(RecipeRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $recipeRepository->expects(self::once())->method('update')->with($recipe);
        $this->inject($this->subject, 'recipeRepository', $recipeRepository);

        $this->subject->updateAction($recipe);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenRecipeFromRecipeRepository()
    {
        $recipe = new Recipe();

        $recipeRepository = $this->getMockBuilder(RecipeRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $recipeRepository->expects(self::once())->method('remove')->with($recipe);
        $this->inject($this->subject, 'recipeRepository', $recipeRepository);

        $this->subject->deleteAction($recipe);
    }
}
