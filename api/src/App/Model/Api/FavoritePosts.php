<?php

namespace App\Model\Api;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class FavoritePosts
{
    /**
     * @var array
     */
    private $ids = [];

    /**
     * @param array $ids
     */
    public function set(array $ids)
    {
        foreach ($ids as $id) {
            $this->addId($id);
        }
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param int|string $id A numeric id.
     *
     * @return bool Whether or not the id has been added to the ids collection.
     */
    public function addId($id)
    {
        if (in_array($id, $this->ids)) {
            return false;
        }

        $this->ids[] = $id;

        return true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(', ', $this->ids);
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('ids', new All([
            new NotBlank(),
            new Type('numeric'),
        ]));
    }
}
