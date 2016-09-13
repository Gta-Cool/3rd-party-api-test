<?php

namespace App\Builder;

use App\Model\User;
use PlaceOrder\Model\User as PlaceHolderUser;

class UserBuilder
{
    /**
     * @param PlaceHolderUser $placeHolderUser
     *
     * @return User
     */
    public function buildWithPlaceHolderData(PlaceHolderUser $placeHolderUser)
    {
        $user = new User();
        $user->id = $placeHolderUser->id;
        $user->name = $placeHolderUser->name;
        $user->email = $placeHolderUser->email;

        return $user;
    }
}
