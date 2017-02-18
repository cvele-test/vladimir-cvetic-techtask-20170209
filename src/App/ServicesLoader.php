<?php

namespace App;

use App;
use Silex\Application;

class ServicesLoader
{
    protected $app;

    /**
     * {@inheritdoc}
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function bindServicesIntoContainer()
    {
        $this->app['app.serializer'] = function () {
            return new Response\Serializer();
        };

        $this->app['recipes.endpoint'] = function () {
            return new Api\Endpoint\RecipesEndpoint();
        };
        $this->app['recipes.hydrator'] = function () {
            return new Api\Hydrator\RecipeHydrator();
        };

        $this->app['ingredients.endpoint'] = function () {
            return new Api\Endpoint\IngredientsEndpoint();
        };
        $this->app['ingredients.hydrator'] = function () {
            return new Api\Hydrator\IngredientHydrator();
        };

        $this->app['api.service'] = function () {
            $api = new Api\Endpoint\EndpointFactory();
            $api->addEndpoint('ingredients', $this->app['data.ingredients'], $this->app['ingredients.endpoint'], $this->app['ingredients.hydrator']);
            $api->addEndpoint('recipes', $this->app['data.recipes'], $this->app['recipes.endpoint'], $this->app['recipes.hydrator']);

            return $api;
        };

        $this->app['lunch.service'] = function () {
            return new Services\LunchService($this->app['api.service']);
        };
    }
}
