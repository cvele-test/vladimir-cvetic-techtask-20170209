<?php

namespace App\Response;

use App\Collection\RecipeCollection;
use App\Entity\Recipe;
use App\Response\Transformer\RecipeTransformer;
use League\Fractal;

class Serializer
{
    /**
     * Serializes object
     * @param  object $object
     * @param  bool $json
     * @return string|array
     */
    public function serialize($object, $json = true)
    {
        if ($object instanceof Recipe) {
            $resource = new Fractal\Resource\Item($object, new RecipeTransformer());
        }

        if ($object instanceof RecipeCollection) {
            $resource = new Fractal\Resource\Collection($object, new RecipeTransformer());
        }

        $fractal = new Fractal\Manager();
        $data = $fractal->createData($resource);
        if ($json === true) {
            return $data->toJson();
        }

        return $data;
    }
}
