<?php

namespace PlaceOrder\Exception;

use InvalidArgumentException;

class UnknownRepositoryNameException extends InvalidArgumentException implements ExceptionInterface
{
}
