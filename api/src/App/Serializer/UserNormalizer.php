<?php

namespace App\Serializer;

use App\Model\User;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param User $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->id,
            'name' => $object->name,
            'email' => $object->email,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof User;
    }
}
