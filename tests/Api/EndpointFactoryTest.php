<?php

namespace Tests\Api;

use App\Api\Endpoint\EndpointFactory;

class EndpointFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EndpointFactory
     */
    private $service;

    public function setUp()
    {
        $this->service = new EndpointFactory();
        $this->service->addEndpoint('ingredients',
                                    dirname(__FILE__).'/../../src/App/Data/ingredients.json',
                                    new \App\Api\Endpoint\IngredientsEndpoint,
                                    new \App\Api\Hydrator\IngredientHydrator);

        $this->service->addEndpoint('recipes',
                                    dirname(__FILE__).'/../../src/App/Data/recipes.json',
                                    new \App\Api\Endpoint\RecipesEndpoint,
                                    new \App\Api\Hydrator\RecipeHydrator);
    }

    public function tearDown()
    {
        unset($this->service);
    }

    public function testGetEndpoint()
    {
        $endpoint = $this->service->getEndpoint('ingredients');
        $this->assertInstanceOf('App\Api\Endpoint\IngredientsEndpoint', $endpoint['endpoint']);
        $this->assertInstanceOf('App\Api\Hydrator\IngredientHydrator', $endpoint['hydrator']);

        $endpoint = $this->service->getEndpoint('recipes');
        $this->assertInstanceOf('App\Api\Endpoint\RecipesEndpoint', $endpoint['endpoint']);
        $this->assertInstanceOf('App\Api\Hydrator\RecipeHydrator', $endpoint['hydrator']);

        $this->expectException(\Exception::class);
        $endpoint = $this->service->getEndpoint('dummy');
    }

    public function testFetch()
    {
        $response = $this->service->fetch('recipes');
        $this->assertInstanceOf('App\Collection\RecipeCollection', $response);
        $this->assertCount(4, $response);

        $response = $this->service->fetch('ingredients');
        $this->assertInstanceOf('App\Collection\IngredientCollection', $response);
        $this->assertCount(16, $response);
    }

    public function testFetchByIdentifiers()
    {
        $response = $this->service->fetchByIdentifiers('ingredients', ['Ham', 'Cheese']);
        $this->assertInstanceOf('App\Collection\IngredientCollection', $response);
        $this->assertCount(2, $response);

        $response = $this->service->fetchByIdentifiers('ingredients', []);
        $this->assertInstanceOf('App\Collection\IngredientCollection', $response);
        $this->assertCount(0, $response);

        $this->expectException(\BadMethodCallException::class);
        $response = $this->service->fetchByIdentifiers('recipes', ['dummy']);
    }

    public function testFetchOne()
    {
        $response = $this->service->fetchOne('ingredients', 'Ham');
        $this->assertInstanceOf('App\Entity\Ingredient', $response);
        $this->assertEquals('Ham', $response->getTitle());

        $response = $this->service->fetchOne('recipes', 'Fry-up');
        $this->assertInstanceOf('App\Entity\Recipe', $response);
        $this->assertEquals('Fry-up', $response->getTitle());
        $this->assertInstanceOf('App\Collection\IngredientCollection', $response->getIngredients());
        $this->assertCount(6, $response->getIngredients());

        $response = $this->service->fetchOne('ingredients', 'Dummy');
        $this->assertInstanceOf('App\Entity\Ingredient', $response);
        $this->assertEquals('Dummy', $response->getTitle());
        $this->assertEquals(null, $response->getUseBy());
        $this->assertEquals(null, $response->getBestBefore());
        $this->assertEquals('Dummy', (string) $response);
    }


}
