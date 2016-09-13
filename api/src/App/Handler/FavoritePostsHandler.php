<?php

namespace App\Handler;

use App\Builder\PostBuilder;
use App\Model\Post;
use App\Model\PostIdCollection;
use PlaceOrder\Model\Post as PlaceHolderPost;
use PlaceOrder\Model\User as PlaceHolderUser;
use PlaceOrder\Repository\PostRepository;
use PlaceOrder\Repository\UserRepository;

class FavoritePostsHandler
{
    /**
     * @var PostRepository
     */
    protected $placeOrderPostRepository;

    /**
     * @var UserRepository
     */
    protected $placeOrderUserRepository;

    /**
     * @var PostBuilder
     */
    protected $postBuilder;

    /**
     * @var PlaceHolderPost[]
     */
    private $placeOrderPosts = [];

    /**
     * @var PlaceHolderUser[]
     */
    private $placeOrderUsers = [];

    /**
     * @var Post[]
     */
    private $posts = [];

    /**
     * @param PostRepository $placeOrderPostRepository
     * @param UserRepository $placeOrderUserRepository
     * @param PostBuilder    $postBuilder
     */
    public function __construct(
        PostRepository $placeOrderPostRepository,
        UserRepository $placeOrderUserRepository,
        PostBuilder $postBuilder
    ) {
        $this->placeOrderPostRepository = $placeOrderPostRepository;
        $this->placeOrderUserRepository = $placeOrderUserRepository;
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

            $placeHolderPost = $this->getPlaceOrderPost($postId);
            $placeHolderUser = null;

            if ($placeHolderPost instanceof PlaceHolderPost && is_int($placeHolderPost->userId)) {
                $placeHolderUser = $this->getPlaceOrderUser($placeHolderPost->userId);
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
    protected function getPlaceOrderPost($postId)
    {
        if (array_key_exists($postId, $this->placeOrderPosts)) {
            return $this->placeOrderPosts[$postId];
        }

        $post = $this->placeOrderPostRepository->find($postId);
        $this->placeOrderPosts[$postId] = $post;

        return $post;
    }

    /**
     * @param int $userId
     *
     * @return PlaceHolderUser|null
     */
    protected function getPlaceOrderUser($userId)
    {
        if (array_key_exists($userId, $this->placeOrderUsers)) {
            return $this->placeOrderUsers[$userId];
        }

        $user = $this->placeOrderUserRepository->find($userId);
        $this->placeOrderUsers[$userId] = $user;

        return $user;
    }
}
