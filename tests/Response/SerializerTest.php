<?php

namespace Tests\Services;

use App\Collection\RecipeCollection;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Response\Serializer;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer $service
     */
    private $service;

    public function setUp()
    {
        $this->service = new Serializer;
    }

    public function tearDown()
    {
        unset($this->service);
    }

    public function testSerializeItem()
    {
        $recipe = new Recipe;
        $recipe->setTitle('dummy');
        $ingredient = new Ingredient;
        $ingredient->setTitle('dummy-ingredient');
        $ingredient->setUseBy(new \DateTime);
        $ingredient->setBestBefore(new \DateTime);
        $recipe->addIngredient($ingredient);

        $result = $this->service->serialize($recipe, false);
        $this->assertInstanceOf('League\Fractal\Resource\Item', $result->getResource());

        $result = $this->service->serialize($recipe, true);
        $this->assertEquals('{"data":{"title":"dummy","ingredients":{"data":[{"title":"dummy-ingredient","best-before":"2017-02-18","use-by":"2017-02-18"}]}}}', $result);
    }

    public function testSerializeCollection()
    {
        $recipe = new Recipe;
        $recipe->setTitle('dummy');
        $ingredient = new Ingredient;
        $ingredient->setTitle('dummy-ingredient');
        $ingredient->setUseBy(new \DateTime);
        $ingredient->setBestBefore(new \DateTime);
        $recipe->addIngredient($ingredient);

        $recipeCollection = new RecipeCollection();
        $recipeCollection->add($recipe);

        $result = $this->service->serialize($recipeCollection, false);
        $this->assertInstanceOf('League\Fractal\Resource\Collection', $result->getResource());

        $result = $this->service->serialize($recipe, true);
        $this->assertEquals('{"data":{"title":"dummy","ingredients":{"data":[{"title":"dummy-ingredient","best-before":"2017-02-18","use-by":"2017-02-18"}]}}}', $result);
    }
}
