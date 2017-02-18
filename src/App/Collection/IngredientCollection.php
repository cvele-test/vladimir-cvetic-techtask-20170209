<?php

namespace App\Collection;

use App\Entity\Ingredient;

/** Collection class for Ingredient Entities **/
class IngredientCollection extends \ArrayObject
{
    /**
     * @param  Ingredient $ingredient
     * @return void
     */
    public function add(Ingredient $ingredient)
    {
        return $this->offsetSet(NULL, $ingredient);
    }

    /**
     * @param  Ingredient $ingredient
     * @return void
     */
    public function remove(Ingredient $ingredient)
    {
        return $this->offsetUnset($this->offsetGet($ingredient));
    }

    /**
     * Filters out ingredinets that are passed their use-by date
     * @param  \DateTime $date
     * @return self
     */
    public function filterOutByUseDate(\DateTime $date): self
    {
        $ingredients = array_filter((array) $this, function($ingredient) use ($date) {
            $interval = $date->diff($ingredient->getUseBy());
            return !(bool) $interval->invert;
        });

        $this->exchangeArray($ingredients);
        return $this;
    }

    public function has(Ingredient $ingredient)
    {
        return in_array($ingredient, (array) $this);
    }
}
