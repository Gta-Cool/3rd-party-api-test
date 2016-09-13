<?php

namespace App\Builder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class ApiResponseBuilder
{
    /**
     * @var string
     */
    const DEFAULT_FORMAT = 'json';

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param mixed  $data
     * @param string $format
     *
     * @return Response
     */
    public function buildResponse($data, $format = self::DEFAULT_FORMAT)
    {
        $dataAsString = $this->serializer->serialize($data, $format);

        switch ($format) {
            case 'json':
            default:
                $response = new JsonResponse();
                $response->setJson($dataAsString);
        }

        return $response;
    }
}
