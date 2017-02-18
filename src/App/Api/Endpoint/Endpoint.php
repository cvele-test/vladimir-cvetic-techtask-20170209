<?php

namespace App\Api\Endpoint;

interface Endpoint
{
    public function fetch(array $endpoints);

    public function fetchOne($identitifer, array $endpoints);
}
