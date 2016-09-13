<?php

namespace App\Controller;

use App\Builder\ApiResponseBuilder;
use App\Exception\BadRequestException;
use App\Exception\InvalidParameterException;
use App\Handler\FavoritePostsHandler;
use App\Provider\FavoritePostsProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FavoritePostsController
{
    /**
     * @var FavoritePostsProvider
     */
    private $favoritePostsProvider;

    /**
     * @var FavoritePostsHandler
     */
    private $favoritePostsHandler;

    /**
     * @var ApiResponseBuilder
     */
    private $apiResponseBuilder;

    /**
     * @param FavoritePostsProvider $favoritePostsProvider
     * @param FavoritePostsHandler  $favoritePostsHandler
     * @param ApiResponseBuilder    $apiResponseBuilder
     */
    public function __construct(
        FavoritePostsProvider $favoritePostsProvider,
        FavoritePostsHandler $favoritePostsHandler,
        ApiResponseBuilder $apiResponseBuilder
    ) {
        $this->favoritePostsProvider = $favoritePostsProvider;
        $this->favoritePostsHandler = $favoritePostsHandler;
        $this->apiResponseBuilder = $apiResponseBuilder;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        try {
            $favoritePostIdCollection = $this->favoritePostsProvider->provide($request);
        } catch (InvalidParameterException $e) {
            throw new BadRequestException($e->getMessage(), $e);
        }

        $posts = $this->favoritePostsHandler->handle($favoritePostIdCollection);

        return $this->apiResponseBuilder->buildResponse($posts);
    }
}
