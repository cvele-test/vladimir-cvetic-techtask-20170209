<?php

namespace App\Api\Endpoint;

use App\Collection\IngredientCollection;

class IngredientsEndpoint implements Endpoint
{
    /**
     * Parsed data from json file.
     *
     * @var array|null
     */
    protected static $data = null;

    protected $endpointName = 'ingredients';

    public function fetch(array $endpoints)
    {
        $this->loadData($endpoints);
        $collection = new IngredientCollection();
        foreach (self::$data['ingredients'] as $ingredient) {
            $collection->add($this->fetchOne($ingredient['title'], $endpoints));
        }

        return $collection;
    }

    public function fetchByIdentifiers(array $identifiers, array $endpoints)
    {
        $this->loadData($endpoints);
        $collection = new IngredientCollection();
        foreach (self::$data['ingredients'] as $ingredient) {
            if (!in_array($ingredient['title'], $identifiers)) {
                continue;
            }

            $collection->add($this->fetchOne($ingredient['title'], $endpoints));
        }

        return $collection;
    }

    public function fetchOne($identitifer, array $endpoints)
    {
        $this->loadData($endpoints);
        $ingredient = array_filter(self::$data['ingredients'], function ($ingredient) use ($identitifer) {
            return strtolower($ingredient['title']) == strtolower($identitifer);
        });
        $ingredient = reset($ingredient);
        if ($ingredient['title'] === null) {
            return $endpoints['ingredients']['hydrator']->hydrate(['title' => $identitifer]);
        }

        return $endpoints['ingredients']['hydrator']->hydrate($ingredient);
    }

    private function loadData($endpoints)
    {
        if (self::$data === null) {
            self::$data = $this->unserializeDataFromPath($endpoints[$this->endpointName]['dataPath']);
        }

        return $this;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private function unserializeDataFromPath($path): array
    {
        if (!file_exists($path)) {
            throw new \Exception(sprintf('JSON file not found at path: `%s`', $path));
        }

        return json_decode(file_get_contents($path), true);
    }

    // /**
    //  * Returns intedients structure based on array titles passed
    //  *
    //  * @param  array $ingredients Array of ingredient title values
    //  * @param array|null $data Optional custom ingredients data
    //  * @return array
    //  */
    // public function findByIngredients(array $ingredients, array $data = null): array
    // {
    //     if ($data === null) {
    //         $data = $this->getAll();
    //     }

    //     if (!self::validateData($data)) {
    //         throw new \Exception("Error Processing Request", 1);
    //     }

    //     return array_filter($data['ingredients'], function($ingredient) use ($ingredients) {
    //         return in_array(strtolower($ingredient['title']), array_map('strtolower', $ingredients));
    //     });
    // }

    // /**
    //  * Filters ingredients by date use-by|best-before
    //  *
    //  * @param \DateTime $date Date to compare agains - current date
    //  * @param string $field Ingredient data set field to test agains use-by|best-before
    //  * @param array|null $data Optional custom ingredients data
    //  * @return array
    //  */
    // private function filterOutByDate(\DateTime $date, $field, array $data = null): array
    // {
    //     if ($data === null) {
    //         $data = $this->getAll();
    //     }

    //     if (!self::validateData($data)) {
    //         throw new \Exception("Error Processing Request");
    //     }

    //     if (count($data['ingredients']) == 0) {
    //         return [];
    //     }

    //     if (!array_key_exists($field, array_values($data['ingredients'])[0])) {
    //         throw new \Exception(sprintf("Field %s does not exist in data array", $field));
    //     }

    //     return array_filter($data['ingredients'], function($ingredient) use ($date, $field) {
    //         $useByDate = \DateTime::createFromFormat('Y-m-d', $ingredient['use-by']);
    //         $interval = $date->diff($useByDate);
    //         return !(bool) $interval->invert;
    //     });
    // }

    // /**
    //  * Filters out ingredients which use by date has passed
    //  * @param \DateTime $date Date to compare agains - current date
    //  * @param array|null $data Optional custom ingredients data
    //  * @return array
    //  */
    // public function filterOutByUseByDate(\DateTime $date, array $data = null): array
    // {
    //     return $this->filterOutByDate($date, 'use-by', $data);
    // }

    // public static function validateData(array $data)
    // {
    //     return array_key_exists('ingredients', $data);
    // }
}
