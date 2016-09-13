<?php

namespace PlaceOrder\Client;

use PlaceOrder\Model\ModelInterface;

interface ClientInterface
{
    CONST DEFAULT_FORMAT = 'json';

    /**
     * @var array
     */
    const NULL_VALUE_BY_FORMAT = [
        'json' => 'null',
    ];

    /**
     * @param string $dataType
     * @param string $id
     * @param string $format
     *
     * @return string
     */
    public function get($dataType, $id, $format = self::DEFAULT_FORMAT);

    /**
     * @param string $dataType
     * @param string $format
     *
     * @return ModelInterface[]
     */
    public function getAll($dataType, $format = self::DEFAULT_FORMAT);
}
