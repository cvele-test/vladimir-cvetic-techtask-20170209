<?php

namespace App\Api\Endpoint;

use App\Collection\IngredientCollection;

class IngredientsEndpoint extends Endpoint
{
    /**
     * {@inheritdoc}
     */
    public function getEndpointName()
    {
        return 'ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(array $endpoints)
    {
        $this->loadData($endpoints);
        $collection = new IngredientCollection();
        foreach ($this->getData()['ingredients'] as $ingredient) {
            $collection->add($this->fetchOne($ingredient['title'], $endpoints));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchByIdentifiers(array $identifiers, array $endpoints)
    {
        $this->loadData($endpoints);
        $collection = new IngredientCollection();
        foreach ($this->getData()['ingredients'] as $ingredient) {
            if (!in_array($ingredient['title'], $identifiers)) {
                continue;
            }

            $collection->add($this->fetchOne($ingredient['title'], $endpoints));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchOne($identitifer, array $endpoints)
    {
        $this->loadData($endpoints);
        $ingredient = array_filter($this->getData()['ingredients'], function ($ingredient) use ($identitifer) {
            return strtolower($ingredient['title']) == strtolower($identitifer);
        });
        $ingredient = reset($ingredient);
        if ($ingredient['title'] === null) {
            return $endpoints['ingredients']['hydrator']->hydrate(['title' => $identitifer]);
        }

        return $endpoints['ingredients']['hydrator']->hydrate($ingredient);
    }
}
