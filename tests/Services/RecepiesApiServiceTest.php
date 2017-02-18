<?php

namespace Tests\Services;

use Silex\Application;
use App\Services\RecepiesApiService;

class RecepiesApiServiceTest extends \PHPUnit_Framework_TestCase
{

    private $service;

    public function setUp()
    {
        $this->service = new RecepiesApiService(dirname(__FILE__) . "/../../src/App/Data/recepies.json");
    }

    public function tearDown()
    {
        unset($this->service);
    }

    public function testFindRecipeIngredients()
    {
        $data = $this->service->findRecipeIngredients('Fry-up');
        $this->assertEquals([
            "Bacon",
            "Eggs",
            "Baked Beans",
            "Mushrooms",
            "Sausage",
            "Bread"
        ], $data);
    }

    public function testFindRecepiesByIngredients()
    {
        $data = $this->service->findRecepiesByIngredients([
            "Bacon",
            "Eggs",
            "Baked Beans",
            "Mushrooms",
            "Sausage",
            "Bread"
        ]);
        $this->assertCount(1, $data);
        $this->assertEquals('Fry-up', $data[1]['title']);

        $data = $this->service->findRecepiesByIngredients([
            "Potato",
            "Lettuce"
        ]);
        $this->assertCount(0, $data);
    }
}
