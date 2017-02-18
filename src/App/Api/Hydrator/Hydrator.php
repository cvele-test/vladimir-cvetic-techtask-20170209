<?php

namespace App\Api\Hydrator;

/**
 * hydrator interface.
 */
interface Hydrator
{
    /**
     * Hydrates object from array.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function hydrate(array $data);
}
