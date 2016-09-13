<?php

namespace App\Model;

/**
 * DTO model User
 */
class User implements ModelInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;
}
