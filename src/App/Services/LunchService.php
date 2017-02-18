<?php

namespace App\Services;

use App\Api\Endpoint\EndpointFactory;
use App\Collection\RecipeCollection;

class LunchService
{
    /**
     * @var EndpointFactory
     */
    protected $endpointFactory;

    /**
     * @param EndpointFactory $endpointFactory
     */
    public function __construct($endpointFactory)
    {
        $this->endpointFactory = $endpointFactory;
    }

    /**
     * Find recepies by available ingredients.
     *
     * @param array          $ingredients
     * @param \DateTime|null $currentDateTime
     *
     * @return array
     */
    public function findLunchOptions(array $ingredients, \DateTime $currentDateTime = null): RecipeCollection
    {
        if ($currentDateTime === null) {
            $currentDateTime = new \DateTime();
        }

        $ingredients = $this->endpointFactory
                          ->fetchByIdentifiers('ingredients', $ingredients)
                          ->filterOutByUseDate($currentDateTime);

        $recipes = $this->endpointFactory
                          ->fetch('recipes')
                          ->filterOutByIngredients($ingredients)
                          ->sortByIngredientBestBefore($currentDateTime);

        return $recipes;
    }
}
