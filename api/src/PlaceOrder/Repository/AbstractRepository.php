<?php

namespace PlaceOrder\Repository;

use PlaceOrder\Client\ClientInterface;
use PlaceOrder\Exception\InvalidModelClassException;
use PlaceOrder\Model\ModelClassInterface;
use PlaceOrder\Model\ModelInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractRepository implements RepositoryInterface, ModelClassInterface
{
    /**
     * @var string
     */
    const RESPONSE_FORMAT = 'json';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $modelClass = $this->getAndCheckModelClass();

        return $this->serializer->deserialize(
            $this->client->get($modelClass::getType(), $id),
            $modelClass,
            self::RESPONSE_FORMAT
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $modelClass = $this->getAndCheckModelClass();

        return $this->serializer->deserialize(
            $this->client->getAll($modelClass::getType()),
            $modelClass,
            self::RESPONSE_FORMAT
        );
    }

    /**
     * Checks if the class exists and is a model class.
     *
     * @return string|ModelInterface A ModelInterface class
     */
    protected function getAndCheckModelClass()
    {
        $modelClass = $this->getModelClass();

        if (!class_exists($modelClass)) {
            throw new InvalidModelClassException(sprintf('Class "%s" does not exist.', $modelClass));
        }

        $interfaces = class_implements($modelClass);

        if (!in_array(ModelInterface::class, $interfaces)) {
            throw new InvalidModelClassException(
                sprintf('Class "%s" must implement "%s".', $modelClass, ModelInterface::class)
            );
        }

        return $modelClass;
    }
}