<?php

namespace App\Api\Endpoint;


interface Endpoint
{

    function fetch(array $endpoints);

    function fetchOne($identitifer, array $endpoints);

}
