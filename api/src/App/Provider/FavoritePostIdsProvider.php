<?php

namespace App\Provider;

use App\Exception\InvalidParameterException;
use App\Model\PostIdCollection;
use Symfony\Component\HttpFoundation\Request;

class FavoritePostIdsProvider
{
    const QUERY_IDS_NAME = 'ids';

    /**
     * @var array
     */
    private $defaultFavoritePostIds;

    /**
     * @param array $defaultFavoritePostIds
     */
    public function __construct(array $defaultFavoritePostIds)
    {
        $this->defaultFavoritePostIds = $defaultFavoritePostIds;
    }

    /**
     * @param Request $request
     *
     * @return PostIdCollection
     */
    public function provide(Request $request)
    {
        $ids = $request->query->get(static::QUERY_IDS_NAME, $this->defaultFavoritePostIds);

        if (!is_array($ids)) {
            throw new InvalidParameterException('ids must be an array');
        }

        $postIdCollection = new PostIdCollection($ids);

        return $postIdCollection;
    }
}
