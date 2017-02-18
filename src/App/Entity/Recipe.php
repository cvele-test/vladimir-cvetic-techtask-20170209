<?php

namespace App\Entity;

use App\Collection\IngredientCollection;

/**
 * recipe entity
 */
class Recipe
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var IngredientCollection
     */
    protected $ingredients;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->ingredients = new IngredientCollection;
    }

    /**
     * Get the value of Title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param Ingredient $ingredient
     * @return self
     */
    public function addIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->append($ingredient);
        return $this;
    }

    /**
     * @param Ingredient $ingredient
     * @return self
     */
    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->remove($ingredient);
    }

    /**
     * @param  IngredientCollection $ingredientCollection
     * @return self
     */
    public function setIngredients(IngredientCollection $ingredientCollection): self
    {
        $this->ingredients = $ingredientCollection;
        return $this;
    }

    /**
     * @return IngredientCollection
     */
    public function getIngredients(): IngredientCollection
    {
        return $this->ingredients;
    }
}
