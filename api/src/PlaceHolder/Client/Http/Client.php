<?php

namespace PlaceHolder\Client\Http;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\ClientException;
use PlaceHolder\Client\ClientInterface;

/**
 * PlaceHolder Http Client
 */
class Client implements ClientInterface
{
    /**
     * @var int
     */
    const HTTP_NOT_FOUND_STATUS_CODE = 404;

    /**
     * @var GuzzleClientInterface
     */
    private $guzzleClient;

    /**
     * @param GuzzleClientInterface $guzzleClient
     */
    public function __construct(GuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * {@inheritdoc}
     */
    public function get($dataType, $id, $format = self::DEFAULT_FORMAT)
    {
        try {
            $response = $this->guzzleClient->request('GET', $this->getUriByDataTypeAndId($dataType, $id));
        } catch (ClientException $e) {
            if (static::HTTP_NOT_FOUND_STATUS_CODE === $e->getResponse()->getStatusCode()) {
                return static::NULL_VALUE_BY_FORMAT[$format];
            }

            throw $e;
        }

        return $response->getBody()->getContents();
    }

    /**
     * {@inheritdoc}
     */
    public function getAll($dataType, $format = self::DEFAULT_FORMAT)
    {
        $response = $this->guzzleClient->request('GET', $this->getUriByDataTypeAndId($dataType));

        return $response->getBody()->getContents();
    }

    /**
     * @param string      $dataType
     * @param string|null $id
     *
     * @return string
     */
    protected function getUriByDataTypeAndId($dataType, $id = null)
    {
        $uri = sprintf('/%s', $dataType);

        if (null !== $id) {
            $uri .= sprintf('/%s', $id);
        }

        return $uri;
    }
}
