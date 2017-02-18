<?php

namespace App\Api\Hydrator;

use App\Api\Hydrator\Hydrator;
use App\Entity\Ingredient;

/**
 * hydrates recepie to entity
 */
class IngredientHydrator implements Hydrator
{
    /**
     * Transforms array to recipe entity
     * @param  mixed  $ingredient
     * @return Ingredient
     */
    public function hydrate($ingredient)
    {
        $entity = new Ingredient;
        $entity->setTitle($ingredient['title']);

        if (array_key_exists('use-by', $ingredient)) {
            $entity->setUseBy(\DateTime::createFromFormat('Y-m-d', $ingredient['use-by']));
        }
        if (array_key_exists('best-before', $ingredient)) {
            $entity->setBestBefore(\DateTime::createFromFormat('Y-m-d', $ingredient['best-before']));
        }

        return $entity;
    }
}
