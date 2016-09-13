<?php

namespace PlaceOrder\Repository;

use PlaceOrder\Model\Post;

class PostRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getModelClass()
    {
        return Post::class;
    }

    /**
     * @inheritDoc
     *
     * @return Post|null
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * @inheritDoc
     *
     * @return Post[]
     */
    public function findAll()
    {
        return parent::findAll();
    }
}
