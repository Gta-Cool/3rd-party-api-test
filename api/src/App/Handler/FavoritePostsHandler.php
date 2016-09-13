<?php

namespace App\Handler;

use App\Builder\PostBuilder;
use App\Model\Post;
use App\Model\Api\FavoritePosts;
use PlaceHolder\Model\Post as PlaceHolderPost;
use PlaceHolder\Model\User as PlaceHolderUser;
use PlaceHolder\Repository\PostRepository;
use PlaceHolder\Repository\UserRepository;

class FavoritePostsHandler
{
    /**
     * @var PostRepository
     */
    protected $placeHolderPostRepository;

    /**
     * @var UserRepository
     */
    protected $placeHolderUserRepository;

    /**
     * @var PostBuilder
     */
    protected $postBuilder;

    /**
     * @var PlaceHolderPost[]
     */
    private $placeHolderPosts = [];

    /**
     * @var PlaceHolderUser[]
     */
    private $placeHolderUsers = [];

    /**
     * @var Post[]
     */
    private $posts = [];

    /**
     * @param PostRepository $placeHolderPostRepository
     * @param UserRepository $placeHolderUserRepository
     * @param PostBuilder    $postBuilder
     */
    public function __construct(
        PostRepository $placeHolderPostRepository,
        UserRepository $placeHolderUserRepository,
        PostBuilder $postBuilder
    ) {
        $this->placeHolderPostRepository = $placeHolderPostRepository;
        $this->placeHolderUserRepository = $placeHolderUserRepository;
        $this->postBuilder = $postBuilder;
    }

    /**
     * @param FavoritePosts $favoritePosts
     *
     * @return Post[]
     */
    public function handle(FavoritePosts $favoritePosts)
    {
        $posts = [];

        foreach ($favoritePosts->getIds() as $postId) {

            if (array_key_exists($postId, $this->posts)) {
                $posts[] = $this->posts[$postId];
                continue;
            }

            $placeHolderPost = $this->getPlaceHolderPost($postId);

            if ($placeHolderPost instanceof PlaceHolderPost) {
                $placeHolderUser = is_int($placeHolderPost->userId)
                    ? $this->getPlaceHolderUser($placeHolderPost->userId)
                    : null
                ;

                $post = $this->postBuilder->buildWithPlaceHolderData($placeHolderPost, $placeHolderUser);
                $this->posts[$postId] = $post;
                $posts[] = $post;
            }
        }

        return $posts;
    }

    /**
     * @param int $postId
     *
     * @return PlaceHolderPost|null
     */
    protected function getPlaceHolderPost($postId)
    {
        if (array_key_exists($postId, $this->placeHolderPosts)) {
            return $this->placeHolderPosts[$postId];
        }

        $post = $this->placeHolderPostRepository->find($postId);
        $this->placeHolderPosts[$postId] = $post;

        return $post;
    }

    /**
     * @param int $userId
     *
     * @return PlaceHolderUser|null
     */
    protected function getPlaceHolderUser($userId)
    {
        if (array_key_exists($userId, $this->placeHolderUsers)) {
            return $this->placeHolderUsers[$userId];
        }

        $user = $this->placeHolderUserRepository->find($userId);
        $this->placeHolderUsers[$userId] = $user;

        return $user;
    }
}
