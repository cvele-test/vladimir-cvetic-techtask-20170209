<?php

namespace App\Collection;

use App\Entity\Recipe;

/** Collection class for Recipe Entities **/
class RecipeCollection extends \ArrayObject
{
    /**
     * @param Recipe $recipe
     */
    public function add(Recipe $recipe)
    {
        return $this->offsetSet(null, $recipe);
    }

    /**
     * @param Recipe $recipe
     */
    public function remove(Recipe $recipe)
    {
        return $this->offsetUnset($this->offsetGet($recipe));
    }

    /**
     * Filters out recepies that do not have
     * ingredients from passed IngredientCollection.
     *
     * @param IngredientCollection $ingredients
     *
     * @return self
     */
    public function filterOutByIngredients(IngredientCollection $ingredients): self
    {
        $recepies = array_filter((array) $this, function ($recipe) use ($ingredients) {
            $recipeIngredientIterator = $recipe->getIngredients()->getIterator();
            while ($recipeIngredientIterator->valid()) {
                if ($ingredients->has($recipeIngredientIterator->current()) === false) {
                    return false;
                }
                $recipeIngredientIterator->next();
            }

            return true;
        });

        $this->exchangeArray($recepies);

        return $this;
    }

    /**
     * Sorts recepies by placing ones who's
     * ingredient has passed best-before to the bottom.
     *
     * @param \DateTime $date
     *
     * @return self
     */
    public function sortByIngredientBestBefore(\DateTime $date): self
    {
        $this->uasort(function ($key, $recipe) use ($date) {
            $recipeIngredientIterator = $recipe->getIngredients()->getIterator();
            while ($recipeIngredientIterator->valid()) {
                $ingredient = $recipeIngredientIterator->current();
                $interval = $date->diff($ingredient->getBestBefore());

                if ($interval->invert === 1) {
                    return -1;
                }

                $recipeIngredientIterator->next();
            }

            return 1;
        });

        return $this;
    }
}
