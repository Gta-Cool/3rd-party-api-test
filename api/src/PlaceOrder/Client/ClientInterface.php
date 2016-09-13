<?php

namespace PlaceOrder\Client;

use PlaceOrder\Model\ModelInterface;

interface ClientInterface
{
    /**
     * @param string $modelClass A model class
     * @param string $id
     *
     * @return ModelInterface|null
     */
    public function get($modelClass, $id);

    /**
     * @param string $modelClass A model class
     *
     * @return ModelInterface[]
     */
    public function getAll($modelClass);
}
