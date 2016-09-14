<?php

namespace PlaceHolder\Repository;

use PlaceHolder\Model\User;

class UserRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getModelClass()
    {
        return User::class;
    }

    /**
     * {@inheritDoc}
     *
     * @return User|null
     */
    public function find($id)
    {
        return parent::find($id);
    }

    /**
     * {@inheritDoc}
     *
     * @return User[]
     */
    public function findAll()
    {
        return parent::findAll();
    }
}
