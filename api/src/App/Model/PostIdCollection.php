<?php

namespace App\Model;

class PostIdCollection
{
    /**
     * @var array
     */
    private $collection;

    /**
     * PostIdCollection constructor.
     *
     * @param array|null $postIds
     */
    public function __construct(array $postIds = null)
    {
        if (null === $postIds) {
            $this->collection = [];
        } else {
            $this->collection = $postIds;
        }
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->collection;
    }

    /**
     * @param int $id
     *
     * @return bool Whether or not the id has been added to the collection.
     */
    public function add($id)
    {
        if (in_array($id, $this->collection)) {
            return false;
        }

        $this->collection[] = $id;

        return true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(', ', $this->collection);
    }
}
