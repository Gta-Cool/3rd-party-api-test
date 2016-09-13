<?php

namespace App\Handler;

use App\Builder\PostBuilder;
use App\Model\Post;
use App\Model\PostIdCollection;
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
     * @param PostIdCollection $postIds
     *
     * @return Post[]
     */
    public function handle(PostIdCollection $postIds)
    {
        $posts = [];

        foreach ($postIds->getAll() as $postId) {

            if (array_key_exists($postId, $this->posts)) {
                $posts[] = $this->posts[$postId];
                continue;
            }

            $placeHolderPost = $this->getPlaceHolderPost($postId);
            $placeHolderUser = null;

            if ($placeHolderPost instanceof PlaceHolderPost && is_int($placeHolderPost->userId)) {
                $placeHolderUser = $this->getPlaceHolderUser($placeHolderPost->userId);
            }

            $post = $this->postBuilder->buildWithPlaceHolderData($placeHolderPost, $placeHolderUser);
            $this->posts[$postId] = $post;
            $posts[] = $post;
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
