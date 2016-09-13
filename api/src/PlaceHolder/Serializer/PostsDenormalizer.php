<?php

namespace PlaceHolder\Serializer;

use PlaceHolder\Model\Post;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PostsDenormalizer extends AbstractModelDenormalizer implements DenormalizerInterface
{
    /**
     * @inheritDoc
     */
    public function getModelClass()
    {
        return Post::class;
    }

    /**
     * {@inheritdoc}
     *
     * @return Post
     */
    protected function denormalizeOne(&$data)
    {
        $post = new Post();
        $post->id = $data['id'];
        $post->title = $data['title'];
        $post->body = $data['body'];
        $post->userId = $data['userId'];

        return $post;
    }
}
