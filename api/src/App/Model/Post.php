<?php

namespace App\Model;

/**
 * DTO model Post
 */
class Post implements ModelInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     * @var User|null
     */
    public $user;
}
