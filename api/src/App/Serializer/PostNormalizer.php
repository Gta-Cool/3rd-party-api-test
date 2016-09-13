<?php

namespace App\Serializer;

use App\Model\Post;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PostNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param Post $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'post_id' => $object->id,
            'title' => $object->title,
            'body' => $object->body,
            'user' => $this->normalizer->normalize($object->user, $format, $context),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Post;
    }
}
