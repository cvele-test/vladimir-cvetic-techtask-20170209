<?php

namespace App\Api\Endpoint;

/**
 * Endpoint base class.
 */
abstract class Endpoint
{
    /**
     * Parsed data from json file.
     *
     * @var array|null
     */
    protected static $data = null;

    /**
     * @return string
     */
    abstract public function getEndpointName();

    /**
     * Fetches all data for endpoint, returns hydrated.
     *
     * @param array $endpoints
     *
     * @return \ArrayObject
     */
    abstract public function fetch(array $endpoints);

    /**
     * Fetches data for single resource.
     *
     * @param mixed $identitifer
     * @param array $endpoints
     *
     * @return mixed
     */
    abstract public function fetchOne($identitifer, array $endpoints);

    /**
     * Fetches data matching identifiers, hydrates.
     *
     * @param array $identitifers
     * @param array $endpoints
     *
     * @return \ArrayObject
     */
    abstract public function fetchByIdentifiers(array $identitifers, array $endpoints);

    /**
     * Loads data for endpoint.
     *
     * @param array $endpoints
     *
     * @return self
     */
    protected function loadData(array $endpoints): self
    {
        if (!isset(self::$data[$this->getEndpointName()]) || self::$data === null) {
            self::$data[$this->getEndpointName()] = $this->unserializeDataFromPath($endpoints[$this->getEndpointName()]['dataPath']);
        }

        return $this;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function unserializeDataFromPath($path): array
    {
        if (!file_exists($path)) {
            throw new \Exception(sprintf('JSON file not found at path: `%s`', $path));
        }

        return json_decode(file_get_contents($path), true);
    }

    public function getData()
    {
        return self::$data[$this->getEndpointName()];
    }
}
