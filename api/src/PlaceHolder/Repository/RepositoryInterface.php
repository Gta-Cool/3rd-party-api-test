<?php

namespace PlaceHolder\Repository;

use PlaceHolder\Model\ModelInterface;

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
