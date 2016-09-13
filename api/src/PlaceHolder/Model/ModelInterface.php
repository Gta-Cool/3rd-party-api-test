<?php

namespace PlaceHolder\Model;

interface ModelInterface
{
    /**
     * @return string
     */
    public static function getType();

    /**
     * @return int
     */
    public function getIdentifier();
}
