<?php

namespace PlaceOrder\Client\Http;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ClientException;
use PlaceOrder\Client\ClientInterface;
use PlaceOrder\Exception\InvalidModelClassException;
use PlaceOrder\Model\ModelInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * PlaceOrder Http Client
 */
class Client implements ClientInterface
{
    /**
     * @var string
     */
    const RESPONSE_FORMAT = 'json';

    /**
     * @var int
     */
    const HTTP_NOT_FOUND_STATUS_CODE = 404;

    /**
     * @var GuzzleClientInterface
     */
    private $guzzleClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param GuzzleClientInterface $guzzleClient
     * @param SerializerInterface   $serializer
     */
    public function __construct(GuzzleClientInterface $guzzleClient, SerializerInterface $serializer)
    {
        $this->guzzleClient = $guzzleClient;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function get($modelClass, $id)
    {
        $this->checkModelClass($modelClass);

        try {
            $response = $this->guzzleClient->request('GET', $this->getUriByModelClassAndId($modelClass, $id));
        } catch (ClientException $e) {
            if (static::HTTP_NOT_FOUND_STATUS_CODE === $e->getResponse()->getStatusCode()) {
                return null;
            }

            throw $e;
        }

        return $this->serializer->deserialize($response->getBody()->getContents(), $modelClass, self::RESPONSE_FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($modelClass)
    {
        $this->checkModelClass($modelClass);

        $response = $this->guzzleClient->request('GET', $this->getUriByModelClassAndId($modelClass));

        return $this->serializer->deserialize($response->getBody()->getContents(), $modelClass, self::RESPONSE_FORMAT);
    }

    /**
     * @param string      $modelClass A model class
     * @param string|null $id
     *
     * @return string
     */
    protected function getUriByModelClassAndId($modelClass, $id = null)
    {
        $this->checkModelClass($modelClass);

        /** @var string|ModelInterface $modelClass */
        $uri = sprintf('/%s', $modelClass::getType());

        if (null !== $id) {
            $uri .= sprintf('/%s', $id);
        }

        return $uri;
    }

    /**
     * Checks if the class exists and is a model class.
     *
     * @param string $modelClass A model class
     */
    protected function checkModelClass($modelClass)
    {
        if (!class_exists($modelClass)) {
            throw new InvalidModelClassException(sprintf('Class "%s" does not exist.', $modelClass));
        }

        $interfaces = class_implements($modelClass);

        if (!in_array(ModelInterface::class, $interfaces)) {
            throw new InvalidModelClassException(
                sprintf('Class "%s" must implement "%s".', $modelClass, ModelInterface::class)
            );
        }
    }
}
