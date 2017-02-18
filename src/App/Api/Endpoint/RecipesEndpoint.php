<?php

namespace App\Api\Endpoint;

use BadMethodCallException;
use App\Collection\RecipeCollection;

class RecipesEndpoint extends Endpoint
{
    /**
     * {@inheritdoc}
     */
    public function getEndpointName()
    {
        return 'recipes';
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(array $endpoints)
    {
        $this->loadData($endpoints);
        $collection = new RecipeCollection();
        foreach ($this->getData()['recipes'] as $recipe) {
            $collection->add($this->fetchOne($recipe['title'], $endpoints));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOne($identitifer, array $endpoints)
    {
        $this->loadData($endpoints);
        $recipe = array_filter($this->getData()['recipes'], function ($recipe) use ($identitifer) {
            return strtolower($recipe['title']) == strtolower($identitifer);
        });
        $recipe = reset($recipe);
        $entity = $endpoints['recipes']['hydrator']->hydrate($recipe);
        foreach ($recipe['ingredients'] as $ingredient) {
            $ingredientEntity = $endpoints['ingredients']['endpoint']->fetchOne($ingredient, $endpoints);
            $entity->addIngredient($ingredientEntity);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BadMethodCallException
     */
    public function fetchByIdentifiers(array $identifiers, array $endpoints)
    {
        throw new BadMethodCallException('Not implemented');
    }
}
