<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiBadRequestHttpException extends BadRequestHttpException implements ApiHttpExceptionInterface
{
    /**
     * @var ApiExceptionInterface
     */
    private $apiException;

    /**
     * @param ApiExceptionInterface $apiException
     * @param string|null           $message
     * @param int                   $code
     */
    public function __construct(ApiExceptionInterface $apiException, $message = null, $code = 0)
    {
        $this->apiException = $apiException;

        parent::__construct(null === $message ? $apiException->getMessage() : $message, $apiException, $code);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        return $this->apiException->getErrors();
    }
}
