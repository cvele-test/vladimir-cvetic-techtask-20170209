<?php

namespace App\Collection;

use App\Entity\Ingredient;

/** Collection class for Ingredient Entities **/
class IngredientCollection extends \ArrayObject
{
    /**
     * @param Ingredient $ingredient
     */
    public function add(Ingredient $ingredient)
    {
        return $this->offsetSet(null, $ingredient);
    }

    /**
     * @param Ingredient $ingredient
     */
    public function remove(Ingredient $ingredient)
    {
        return $this->offsetUnset($this->offsetGet($ingredient));
    }

    /**
     * Filters out ingredinets that are passed their use-by date.
     *
     * @param \DateTime $date
     *
     * @return self
     */
    public function filterOutByUseDate(\DateTime $date): self
    {
        $ingredients = array_filter((array) $this, function ($ingredient) use ($date) {
            $interval = $date->diff($ingredient->getUseBy());

            return !(bool) $interval->invert;
        });

        $this->exchangeArray($ingredients);

        return $this;
    }

    /**
     * Checks if collection has Ingredient
     * @param  Ingredient $ingredient
     * @return bool
     */
    public function has(Ingredient $ingredient): bool
    {
        return in_array($ingredient, (array) $this);
    }
}
