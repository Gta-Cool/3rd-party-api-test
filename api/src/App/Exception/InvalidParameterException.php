<?php

namespace App\Exception;

use Exception;
use InvalidArgumentException;

class InvalidParameterException extends InvalidArgumentException implements ApiExceptionInterface
{
    /**
     * @var string
     */
    const MESSAGE_PATTERN = '"%s" must be of type "%s".';

    /**
     * @var string
     */
    const ERROR_PATTERN = 'Must be of type "%s".';

    /**
     * @var string
     */
    private $parameterName;

    /**
     * @var string
     */
    private $expectedType;

    /**
     * @param string         $parameterName
     * @param string         $expectedType
     * @param Exception|null $previous
     */
    public function __construct($parameterName, $expectedType, Exception $previous = null)
    {
        $this->parameterName = $parameterName;
        $this->expectedType = $expectedType;

        parent::__construct($this->buildMessage(), 0, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getErrors()
    {
        return [
            $this->parameterName => sprintf(static::ERROR_PATTERN, $this->expectedType),
        ];
    }

    /**
     * @return string
     */
    protected function buildMessage()
    {
        return sprintf(static::MESSAGE_PATTERN, $this->parameterName, $this->expectedType);
    }
}
