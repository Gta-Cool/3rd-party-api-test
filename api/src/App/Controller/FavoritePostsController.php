<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class FavoritePostsController
{
    public function listAction()
    {
        return new JsonResponse([
            [
                'post_id' => 35,
                'title' => 'Lorem ipsum',
                'body' => 'Lorem ipsum dolor si amet.',
                'user' => [
                    'id' => 1,
                    'name' => 'John',
                    'email' => 'john@yipicaey.com',
                ]
            ],
        ]);
    }
}
