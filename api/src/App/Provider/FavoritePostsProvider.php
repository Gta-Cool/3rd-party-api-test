<?php

namespace App\Provider;

use App\Exception\InvalidParameterException;
use App\Exception\ViolationsException;
use App\Model\Api\FavoritePosts;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FavoritePostsProvider
{
    /**
     * @var string
     */
    const QUERY_IDS_NAME = 'ids';

    /**
     * @var array
     */
    private $defaultFavoritePostIds;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param array              $defaultFavoritePostIds
     * @param ValidatorInterface $validator
     */
    public function __construct(array $defaultFavoritePostIds, ValidatorInterface $validator)
    {
        $this->defaultFavoritePostIds = $defaultFavoritePostIds;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     *
     * @return FavoritePosts
     */
    public function provide(Request $request)
    {
        $ids = $request->query->get(static::QUERY_IDS_NAME, $this->defaultFavoritePostIds);

        if (!is_array($ids)) {
            throw new InvalidParameterException(static::QUERY_IDS_NAME, 'array');
        }

        $favoritePosts = new FavoritePosts();
        $favoritePosts->set($ids);

        $errors = $this->validator->validate($favoritePosts);
        if (0 < count($errors)) {
            throw new ViolationsException($errors);
        }

        return $favoritePosts;
    }
}
