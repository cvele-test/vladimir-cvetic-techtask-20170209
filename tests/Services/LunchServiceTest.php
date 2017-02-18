<?php

namespace Tests\Services;

use App\Api\Endpoint\EndpointFactory;
use App\Services\LunchService;

class LunchServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LunchService
     */
    private $service;

    public function setUp()
    {
        $endpointFactory = new EndpointFactory();
        $endpointFactory->addEndpoint('ingredients',
                                    dirname(__FILE__).'/../../src/App/Data/ingredients.json',
                                    new \App\Api\Endpoint\IngredientsEndpoint(),
                                    new \App\Api\Hydrator\IngredientHydrator());

        $endpointFactory->addEndpoint('recipes',
                                    dirname(__FILE__).'/../../src/App/Data/recipes.json',
                                    new \App\Api\Endpoint\RecipesEndpoint(),
                                    new \App\Api\Hydrator\RecipeHydrator());

        $this->service = new LunchService($endpointFactory);
    }

    public function tearDown()
    {
        unset($this->service);
    }

    public function testFindLunchOptions()
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2017-02-13');
        $recipes = $this->service->findLunchOptions([
            'Ham', 'Cheese', 'Bread', 'Butter',
        ], $date);
        $this->assertInstanceOf('App\Collection\RecipeCollection', $recipes);
        $this->assertCount(1, $recipes);

        $date = \DateTime::createFromFormat('Y-m-d', '2017-02-14');
        $recipes = $this->service->findLunchOptions([
            'Ham', 'Cheese', 'Bread', 'Butter',
        ], $date);
        $this->assertInstanceOf('App\Collection\RecipeCollection', $recipes);
        $this->assertCount(0, $recipes);
    }
}
