<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Tests\Unit\Controller;

use BokuNo\Bokunorecipe\Controller\RecipeController;
use BokuNo\Bokunorecipe\Domain\Model\Category;
use BokuNo\Bokunorecipe\Domain\Model\Recipe;
use BokuNo\Bokunorecipe\Domain\Repository\CategoryRepository;
use BokuNo\Bokunorecipe\Domain\Repository\RecipeRepository;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Markus Ketterer <ketterer.markus@gmx.at>
 */
#[AllowMockObjectsWithoutExpectations]
class RecipeControllerTest extends UnitTestCase
{
    /**
     * @var RecipeController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected RecipeRepository&MockObject $recipeRepository;

    protected CategoryRepository&MockObject $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->recipeRepository = $this->createMock(RecipeRepository::class);
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(RecipeController::class))
            ->setConstructorArgs([$this->recipeRepository, $this->categoryRepository])
            ->onlyMethods(['htmlResponse', 'redirect'])
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testListActionFetchesAllRecipesFromRepositoryAndAssignsThemToView(): void
    {
        $recipe = new Recipe();
        $allRecipes = new ObjectStorage();
        $allRecipes->attach($recipe);
        $categories = [new Category()];
        $response = $this->createMock(ResponseInterface::class);

        $request = $this->createMock(RequestInterface::class);
        $request->expects(self::exactly(2))->method('hasArgument')->willReturn(false);
        $this->subject->_set('request', $request);
        $this->subject->_set('settings', ['recipeCategoryUid' => 42]);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assignMultiple')->with(self::callback(
            static function (array $assignedValues) use ($categories, $recipe): bool {
                return $assignedValues['recipes'] === [$recipe]
                    && $assignedValues['categories'] === $categories
                    && $assignedValues['selCategories'] === []
                    && isset($assignedValues['paginator'], $assignedValues['paging'], $assignedValues['pages']);
            }
        ));
        $this->subject->_set('view', $view);

        $this->recipeRepository->expects(self::once())->method('findAll')->willReturn($allRecipes);
        $this->recipeRepository->expects(self::once())
            ->method('getAllCategoriesFromPid')
            ->with(42)
            ->willReturn($categories);
        $this->subject->expects(self::once())->method('htmlResponse')->willReturn($response);

        self::assertSame($response, $this->subject->listAction());
    }

    public function testShowActionAssignsTheGivenRecipeToView(): void
    {
        $recipe = new Recipe();
        $response = $this->createMock(ResponseInterface::class);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('recipe', $recipe);
        $this->subject->expects(self::once())->method('htmlResponse')->willReturn($response);

        self::assertSame($response, $this->subject->showAction($recipe));
    }

    public function testCreateActionAddsTheGivenRecipeToRecipeRepositoryAndRedirects(): void
    {
        $recipe = new Recipe();
        $response = $this->createMock(ResponseInterface::class);

        $this->recipeRepository->expects(self::once())->method('add')->with($recipe);
        $this->subject->expects(self::once())->method('redirect')->with('list')->willReturn($response);

        self::assertSame($response, $this->subject->createAction($recipe));
    }

    public function testEditActionAssignsTheGivenRecipeToView(): void
    {
        $recipe = new Recipe();
        $response = $this->createMock(ResponseInterface::class);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('recipe', $recipe);
        $this->subject->expects(self::once())->method('htmlResponse')->willReturn($response);

        self::assertSame($response, $this->subject->editAction($recipe));
    }

    public function testUpdateActionUpdatesTheGivenRecipeInRecipeRepositoryAndRedirects(): void
    {
        $recipe = new Recipe();
        $response = $this->createMock(ResponseInterface::class);

        $this->recipeRepository->expects(self::once())->method('update')->with($recipe);
        $this->subject->expects(self::once())->method('redirect')->with('list')->willReturn($response);

        self::assertSame($response, $this->subject->updateAction($recipe));
    }

    public function testDeleteActionRemovesTheGivenRecipeFromRecipeRepositoryAndRedirects(): void
    {
        $recipe = new Recipe();
        $response = $this->createMock(ResponseInterface::class);

        $this->recipeRepository->expects(self::once())->method('remove')->with($recipe);
        $this->subject->expects(self::once())->method('redirect')->with('list')->willReturn($response);

        self::assertSame($response, $this->subject->deleteAction($recipe));
    }
}
