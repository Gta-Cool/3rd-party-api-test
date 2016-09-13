<?php

namespace App\Builder;

use App\Exception\InvalidArgumentException;
use App\Model\Post;
use PlaceHolder\Model\Post as PlaceHolderPost;
use PlaceHolder\Model\User as PlaceHolderUser;

class PostBuilder
{
    /**
     * @var UserBuilder
     */
    private $userBuilder;

    /**
     * @param UserBuilder $userBuilder
     */
    public function __construct(UserBuilder $userBuilder)
    {
        $this->userBuilder = $userBuilder;
    }

    /**
     * @param PlaceHolderPost      $placeHolderPost
     * @param PlaceHolderUser|null $placeHolderUser
     *
     * @return Post
     */
    public function buildWithPlaceHolderData(PlaceHolderPost $placeHolderPost, PlaceHolderUser $placeHolderUser = null)
    {
        if ($placeHolderUser instanceof PlaceHolderUser && $placeHolderPost->userId !== $placeHolderUser->id) {
            new InvalidArgumentException(
                sprintf(
                    'Post userId "%s" should be the same than user id "%s"',
                    $placeHolderPost->userId,
                    $placeHolderUser->id
                )
            );
        }

        $post = new Post();

        $post->id = $placeHolderPost->id;
        $post->title = $placeHolderPost->title;
        $post->body = $placeHolderPost->body;

        if ($placeHolderUser instanceof PlaceHolderUser) {
            $post->user = $this->userBuilder->buildWithPlaceHolderData($placeHolderUser);
        } else {
            $post->user = null;
        }

        return $post;
    }
}
