<?php

namespace App\Api\Endpoint;

use App\Collection\RecipeCollection;

class RecipesEndpoint implements Endpoint
{
    /**
     * Parsed data from json file
     *
     * @var array|null
     */
    protected static $data = null;

    protected $endpointName = 'recipes';

    public function fetch(array $endpoints)
    {
        $this->loadData($endpoints);
        $collection = new RecipeCollection;
        foreach(self::$data['recipes'] as $recipe)
        {
            $collection->add($this->fetchOne($recipe['title'], $endpoints));
        }

        return $collection;
    }

    public function fetchOne($identitifer, array $endpoints)
    {
        $this->loadData($endpoints);
        $recipe = array_filter(self::$data['recipes'], function($recipe) use ($identitifer) {
            return strtolower($recipe['title']) == strtolower($identitifer);
        });
        $recipe = reset($recipe);
        $entity = $endpoints['recipes']['hydrator']->hydrate($recipe);
        foreach($recipe['ingredients'] as $ingredient) {
            $ingredientEntity = $endpoints['ingredients']['endpoint']->fetchOne($ingredient, $endpoints);
            $entity->addIngredient($ingredientEntity);
        }
        return $entity;
    }

    private function loadData($endpoints)
    {
        if (self::$data === null) {
            self::$data = $this->unserializeDataFromPath($endpoints[$this->endpointName]['dataPath']);
        }

        return $this;
    }

    /**
     * @param  string $path
     * @return array
     */
    private function unserializeDataFromPath($path): array
    {
        if (!file_exists($path)) {
            throw new \Exception(sprintf("JSON file not found at path: `%s`", $path));
        }

        return json_decode(file_get_contents($path), true);
    }
    //
    // public function findRecipeIngredients($title, array $data = null): array
    // {
    //     if ($data === null) {
    //         $data = $this->getAll();
    //     }
    //
    //     // Treating recipe title as unique field
    //     $recipe = array_filter($data['recipes'], function($recipe) use ($title) {
    //         return strtolower($title) == strtolower($recipe['title']);
    //     });
    //     return reset($recipe)['ingredients'];
    // }
    //
    // /**
    //  * Finds all recepies wich contain passed ingredients
    //  * @param  array  $ingredients array of ingredient strings
    //  * @param  array|null $data
    //  * @return array
    //  */
    // public function findRecepiesByIngredients(array $ingredients, $data = null): array
    // {
    //     if ($data === null) {
    //         $data = $this->getAll();
    //     }
    //
    //     return array_filter($data['recipes'], function($recipe) use ($ingredients) {
    //         return array_map('strtolower', $recipe['ingredients']) == array_map('strtolower', $ingredients);
    //     });
    // }


}
