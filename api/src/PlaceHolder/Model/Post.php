<?php

namespace PlaceHolder\Model;

/**
 * DTO Post object
 */
class Post implements ModelInterface
{
    /**
     * @var string
     */
    const TYPE = 'posts';

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
     * @var int
     */
    public $userId;

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
