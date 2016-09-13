<?php

namespace PlaceOrder\Serializer;

use PlaceOrder\Model\Post;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class PostsDenormalizer extends AbstractModelDenormalizer implements DenormalizerInterface
{
    /**
     * @inheritDoc
     */
    protected function getModelClass()
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
