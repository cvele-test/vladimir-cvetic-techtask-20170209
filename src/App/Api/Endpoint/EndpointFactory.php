<?php

namespace App\Api\Endpoint;

use App\Api\Hydrator\Hydrator;

class EndpointFactory
{
    /**
     * @var array
     */
    protected $endpoints = [];

    /**
     * Adds endpoint to factory
     *
     * @param mixed $endpointIdentifier
     * @param string $dataPath
     * @param Endpoint $endpoint
     * @param Hydrator $hydrator
     * @return self;
     */
    public function addEndpoint($endpointIdentifier, $dataPath, Endpoint $endpoint, Hydrator $hydrator)
    {
        $this->endpoints[$endpointIdentifier] = [
            'endpoint' => $endpoint,
            'hydrator' => $hydrator,
            'dataPath' => $dataPath
        ];

        return $this;
    }

    /**
     * Gets endpoint from factory
     *
     * @param  mixed $endpointIdentifier
     * @return self
     */
    public function getEndpoint($endpointIdentifier)
    {
        if (array_key_exists($endpointIdentifier, $this->endpoints) == false) {
            throw new \Exception(sprintf("Endpoint `%s` does not exist.", $endpointIdentifier));
        }

        return $this->endpoints[$endpointIdentifier];
    }

    public function fetch($endpointIdentifier)
    {
        $endpoint = $this->getEndpoint($endpointIdentifier);
        $result = $endpoint['endpoint']->fetch($this->endpoints);
        return $result;
    }

    public function fetchByIdentifiers($endpointIdentifier, array $identifiers)
    {
        $endpoint = $this->getEndpoint($endpointIdentifier);
        $result = $endpoint['endpoint']->fetchByIdentifiers($identifiers, $this->endpoints);
        return $result;
    }

    public function fetchOne($endpointIdentifier, $resourceIdentifier)
    {
        $endpoint = $this->getEndpoint($endpointIdentifier);
        $result = $endpoint['endpoint']->fetchOne($resourceIdentifier, $this->endpoints);
        return $result;
    }
}
