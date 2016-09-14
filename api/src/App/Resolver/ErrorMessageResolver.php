<?php

namespace App\Resolver;

class ErrorMessageResolver
{
    /**
     * @var string
     */
    const DEFAULT_MESSAGE = 'An error occurred.';

    /**
     * @var array
     */
    const MESSAGES = [
        '404' => 'Resource not found.',
        '4xx' => 'An error occurred on the client.',
        '500' => 'Internal server error.',
        '5xx' => 'An error occurred on the server.',
    ];

    /**
     * @param int $code
     *
     * @return string
     */
    public function resolve($code)
    {
        $codesToTry = [(string)$code, substr((string)$code, 0, 2).'x', substr((string)$code, 0, 1).'xx'];

        foreach ($codesToTry as $codeToTry) {
            if (array_key_exists($codeToTry, static::MESSAGES)) {
                return static::MESSAGES[$codeToTry];
            }
        }

        return static::DEFAULT_MESSAGE;
    }
}
