<?php

namespace PlaceOrder\Repository;

use PlaceOrder\Model\ModelInterface;

interface RepositoryInterface
{
    /**
     * @param int $id
     *
     * @return ModelInterface|null
     */
    public function find($id);

    /**
     * @return ModelInterface[]
     */
    public function findAll();
}
