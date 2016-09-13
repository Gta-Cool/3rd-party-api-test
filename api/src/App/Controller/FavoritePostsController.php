<?php

namespace App\Controller;

use App\Exception\BadRequestException;
use App\Exception\InvalidParameterException;
use App\Provider\FavoritePostIdsProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FavoritePostsController
{
    /**
     * @var FavoritePostIdsProvider
     */
    private $favoritePostIdsProvider;

    /**
     * @param FavoritePostIdsProvider $favoritePostIdsProvider
     */
    public function __construct(FavoritePostIdsProvider $favoritePostIdsProvider)
    {
        $this->favoritePostIdsProvider = $favoritePostIdsProvider;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        try {
            $favoritePostIdCollection = $this->favoritePostIdsProvider->provide($request);
        } catch (InvalidParameterException $e) {
            throw new BadRequestException($e->getMessage(), $e);
        }

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
