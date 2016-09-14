<?php

namespace App\Builder;

use App\Exception\ApiHttpExceptionInterface;
use App\Exception\UnavailableFormat;
use App\Resolver\ErrorMessageResolver;
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
     * @var ErrorMessageResolver
     */
    private $errorMessageResolver;

    /**
     * @param Serializer           $serializer
     * @param ErrorMessageResolver $errorMessageResolver
     */
    public function __construct(Serializer $serializer, ErrorMessageResolver $errorMessageResolver)
    {
        $this->serializer = $serializer;
        $this->errorMessageResolver = $errorMessageResolver;
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

        return $this->getResponseFromFormat($format, $dataAsString);
    }

    /**
     * @param int    $code
     * @param string $format
     *
     * @return Response
     */
    public function buildErrorResponse(
        $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        $format = self::DEFAULT_FORMAT
    ) {
        $data = [
            'code' => $code,
            'message' => $this->errorMessageResolver->resolve($code),
        ];

        $dataAsString = $this->serializer->serialize($data, $format);

        return $this->getResponseFromFormat($format, $dataAsString);
    }

    /**
     * @param ApiHttpExceptionInterface $apiHttpException
     * @param string                    $format
     *
     * @return Response
     */
    public function buildApiHttpExceptionResponse(
        ApiHttpExceptionInterface $apiHttpException,
        $format = self::DEFAULT_FORMAT
    ) {
        $data = [
            'code' => $apiHttpException->getStatusCode(),
            'message' => $this->errorMessageResolver->resolve($apiHttpException->getStatusCode()),
            'errors' => $apiHttpException->getErrors(),
        ];

        $dataAsString = $this->serializer->serialize($data, $format);

        return $this->getResponseFromFormat($format, $dataAsString);
    }

    /**
     * @param $format
     * @param $dataAsString
     *
     * @return Response
     */
    protected function getResponseFromFormat($format, $dataAsString)
    {
        switch ($format) {
            case 'json':
                $response = new JsonResponse();
                $response->setJson($dataAsString);
                break;
            default:
                throw new UnavailableFormat(sprintf('"%s" is unavailable as format', $format));
        }

        return $response;
    }
}
