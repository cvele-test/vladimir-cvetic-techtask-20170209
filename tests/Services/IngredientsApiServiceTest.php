<?php

namespace Tests\Services;

use Silex\Application;
use App\Services\IngredientsApiService;


class IngredientsApiServiceTest extends \PHPUnit_Framework_TestCase
{

    private $ingredientsService;

    public function setUp()
    {
        $this->ingredientsService = new IngredientsApiService(dirname(__FILE__) . "/../../src/App/Data/ingredients.json");
    }

    public function tearDown()
    {
        unset($this->ingredientsService);
    }

    public function testFindByIngredients()
    {
        $data = $this->ingredientsService->findByIngredients(['Cheese', 'Bacon']);
        $this->assertCount(2, $data);
        $this->assertEquals('2017-02-13', $data[1]['use-by']);
        $this->assertEquals('2017-02-27', $data[4]['use-by']);

        $data = $this->ingredientsService->findByIngredients(['Cheese', 'Bacon'], ['ingredients' => []]);
        $this->assertCount(0, $data);

        $this->expectException(\Exception::class);
        $data = $this->ingredientsService->findByIngredients(['Cheese', 'Bacon'], ['dummy'=>[]]);
    }

    public function testFilterOutByUseByDate()
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2017-02-14');
        $data = $this->ingredientsService->filterOutByUseByDate($date);
        $this->assertCount(14, $data);

        $date = \DateTime::createFromFormat('Y-m-d', '2017-02-28');
        $data = $this->ingredientsService->filterOutByUseByDate($date);
        $this->assertCount(0, $data);

        $date = \DateTime::createFromFormat('Y-m-d', '2017-02-08');
        $data = $this->ingredientsService->filterOutByUseByDate($date);
        $this->assertCount(15, $data);
    }

    public function testGetAll()
    {
        $data = $this->ingredientsService->getAll();
        $this->assertArrayHasKey('ingredients', $data);
        $this->assertCount(16, $data['ingredients']);
    }

}
