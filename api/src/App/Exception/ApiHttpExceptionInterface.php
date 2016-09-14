<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

interface ApiHttpExceptionInterface extends ApiExceptionInterface, HttpExceptionInterface
{
}
