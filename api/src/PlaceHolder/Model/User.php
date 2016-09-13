<?php

namespace PlaceHolder\Model;

/**
 * DTO User object
 */
class User implements ModelInterface
{
    /**
     * @var string
     */
    const TYPE = 'users';

    /**
     * @var int|string
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

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return static::TYPE;
    }
}
