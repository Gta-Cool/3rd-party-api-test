<?php

namespace App\Exception;

use Exception;
use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationList;

class ViolationsException extends RuntimeException implements ExceptionInterface
{
    /**
     * @var ConstraintViolationList
     */
    private $violations;

    /**
     * @param ConstraintViolationList $violations
     * @param Exception|null          $previous
     */
    public function __construct(ConstraintViolationList $violations, Exception $previous = null)
    {
        $this->violations = $violations;

        parent::__construct($this->buildMessage(), 0, $previous);
    }

    /**
     * @return ConstraintViolationList
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * @return array
     */
    public function getViolationsAsArray()
    {
        $result = [];

        foreach ($this->violations as $violation) {
            if (!isset($result[$violation->getPropertyPath()])) {
                $result[$violation->getPropertyPath()] = [];
            }

            $result[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function buildMessage()
    {
        $message = '';

        foreach ($this->violations as $violation) {
            $message .= sprintf('%s: %s / ', $violation->getPropertyPath(), $violation->getMessage());
        }

        return $message;
    }
}
