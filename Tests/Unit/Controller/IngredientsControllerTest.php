<?php

declare(strict_types=1);

namespace BokuNo\Bokunorecipe\Tests\Unit\Controller;

use BokuNo\Bokunorecipe\Domain\Model\Ingredients;
use BokuNo\Bokunorecipe\Domain\Repository\IngredientsRepository;
use BokuNo\Bokunorecipe\Controller\IngredientsController;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 *
 * @author Markus Ketterer <ketterer.markus@gmx.at>
 */
#[AllowMockObjectsWithoutExpectations]
class IngredientsControllerTest extends UnitTestCase
{
    /**
     * @var IngredientsController|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected IngredientsRepository&MockObject $ingredientsRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ingredientsRepository = $this->createMock(IngredientsRepository::class);
        $this->subject = $this->getMockBuilder($this->buildAccessibleProxy(IngredientsController::class))
            ->setConstructorArgs([$this->ingredientsRepository])
            ->onlyMethods(['htmlResponse', 'redirect'])
            ->getMock();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testListActionFetchesAllIngredientsFromRepositoryAndAssignsThemToView(): void
    {
        $ingredient = new Ingredients();
        $allIngredients = new ObjectStorage();
        $allIngredients->attach($ingredient);
        $response = $this->createMock(ResponseInterface::class);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('ingredients', $allIngredients);
        $this->subject->_set('view', $view);
        $this->ingredientsRepository->expects(self::once())->method('findAll')->willReturn($allIngredients);
        $this->subject->expects(self::once())->method('htmlResponse')->willReturn($response);

        self::assertSame($response, $this->subject->listAction());
    }

    public function testShowActionAssignsTheGivenIngredientsToView(): void
    {
        $ingredients = new Ingredients();
        $response = $this->createMock(ResponseInterface::class);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('ingredients', $ingredients);
        $this->subject->expects(self::once())->method('htmlResponse')->willReturn($response);

        self::assertSame($response, $this->subject->showAction($ingredients));
    }

    public function testCreateActionAddsTheGivenIngredientsToIngredientsRepositoryAndRedirects(): void
    {
        $ingredients = new Ingredients();
        $response = $this->createMock(ResponseInterface::class);

        $this->ingredientsRepository->expects(self::once())->method('add')->with($ingredients);
        $this->subject->expects(self::once())->method('redirect')->with('list')->willReturn($response);

        self::assertSame($response, $this->subject->createAction($ingredients));
    }

    public function testEditActionAssignsTheGivenIngredientsToView(): void
    {
        $ingredients = new Ingredients();
        $response = $this->createMock(ResponseInterface::class);

        $view = $this->getMockBuilder(ViewInterface::class)->getMock();
        $this->subject->_set('view', $view);
        $view->expects(self::once())->method('assign')->with('ingredients', $ingredients);
        $this->subject->expects(self::once())->method('htmlResponse')->willReturn($response);

        self::assertSame($response, $this->subject->editAction($ingredients));
    }

    public function testUpdateActionUpdatesTheGivenIngredientsInIngredientsRepositoryAndRedirects(): void
    {
        $ingredients = new Ingredients();
        $response = $this->createMock(ResponseInterface::class);

        $this->ingredientsRepository->expects(self::once())->method('update')->with($ingredients);
        $this->subject->expects(self::once())->method('redirect')->with('list')->willReturn($response);

        self::assertSame($response, $this->subject->updateAction($ingredients));
    }

    public function testDeleteActionRemovesTheGivenIngredientsFromIngredientsRepositoryAndRedirects(): void
    {
        $ingredients = new Ingredients();
        $response = $this->createMock(ResponseInterface::class);

        $this->ingredientsRepository->expects(self::once())->method('remove')->with($ingredients);
        $this->subject->expects(self::once())->method('redirect')->with('list')->willReturn($response);

        self::assertSame($response, $this->subject->deleteAction($ingredients));
    }
}
