<?php

namespace UIoT\metadata;

/**
 * Class Metadata
 * @package UIoT\metadata
 */
final class Metadata
{
    const META_RESOURCES = 'META_RESOURCES';
    const META_PROPERTIES = 'META_PROPERTIES';

    public static function META_RESOURCES() {
        return constant("self::META_RESOURCES");
    }

    public static function META_PROPERTIES() {
        return constant("self::META_PROPERTIES");
    }

}