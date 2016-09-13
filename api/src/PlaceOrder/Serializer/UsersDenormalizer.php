<?php

namespace PlaceOrder\Serializer;

use PlaceOrder\Model\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UsersDenormalizer extends AbstractModelDenormalizer implements DenormalizerInterface
{
    /**
     * @inheritDoc
     */
    protected function getModelClass()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     *
     * @return User
     */
    protected function denormalizeOne(&$data)
    {
        $user = new User();
        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];

        return $user;
    }
}
