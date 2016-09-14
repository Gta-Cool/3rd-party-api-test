<?php

namespace App\Exception;

interface ApiExceptionInterface extends ExceptionInterface
{
    /**
     * @return array
     */
    public function getErrors();
}
