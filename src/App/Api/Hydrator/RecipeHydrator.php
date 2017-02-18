<?php

namespace App\Api\Hydrator;

use App\Api\Hydrator\Hydrator;
use App\Entity\Recipe;

/**
 * hydrates recepie to entity
 */
class RecipeHydrator implements Hydrator
{
    /**
     * Transforms array to recipe entity
     * @param  array  $recipe
     * @return Recipe
     */
    public function hydrate($recipe)
    {
        $entity = new Recipe;
        $entity->setTitle($recipe['title']);

        return $entity;
    }
}
