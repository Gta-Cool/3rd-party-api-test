<?php

namespace PlaceOrder\Serializer;

use PlaceOrder\Model\ModelClassInterface;
use PlaceOrder\Model\ModelInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractModelDenormalizer implements DenormalizerInterface, ModelClassInterface
{
    /**
     * @inheritDoc
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (null === $data || empty($data)) {
            return $data;
        }

        if (false === is_array(reset($data))) {
            return $this->denormalizeOne($data);
        }

        $result = [];
        array_walk(
            $data,
            function (&$data) use (&$result) {
                $modelObject = $this->denormalizeOne($data);
                $result[$modelObject->getIdentifier()] = $modelObject;
            }
        );

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        $finalType = is_int($pos = strpos($type, '[]')) ? substr($type, 0, $pos) : $type;

        return $this->getModelClass() === $finalType;
    }

    /**
     * Denormalizes into a Model object.
     *
     * @param array $data
     *
     * @return ModelInterface
     */
    abstract protected function denormalizeOne(&$data);
}
