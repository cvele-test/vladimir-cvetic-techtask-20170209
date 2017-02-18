<?php

namespace App\Response\Transformer;

use App\Entity\Recipe;
use League\Fractal\TransformerAbstract;

class RecipeTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'ingredients'
    ];

    /**
     * Turn this item object into a generic array
     * @param Recipe $recipe
     * @return array
     */
    public function transform(Recipe $recipe)
    {
        return [
            'title' => $recipe->getTitle(),
        ];
    }

    /**
     * Include Ingredients
     *
     * @return League\Fractal\ItemResource
     */
    public function includeIngredients(Recipe $recipe)
    {
        return $this->collection($recipe->getIngredients(), new IngredientTransformer);
    }
}
