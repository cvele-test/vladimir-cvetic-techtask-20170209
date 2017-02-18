<?php

namespace App\Response\Transformer;

use App\Entity\Ingredient;
use League\Fractal\TransformerAbstract;

class IngredientTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     * @param Ingredient $ingredient
     * @return array
     */
    public function transform(Ingredient $ingredient)
    {
        return [
            'title'       => $ingredient->getTitle(),
            'best-before' => $ingredient->getBestBefore()->format('Y-m-d'),
            'use-by'      => $ingredient->getUseBy()->format('Y-m-d')
        ];
    }
}
