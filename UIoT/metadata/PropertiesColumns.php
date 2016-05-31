<?php

namespace UIoT\metadata;

/**
 * Class Properties
 * @package UIoT\metadata
 */
final class Properties
{
    const PROP_ID = 'ID';
    const RSRC_ID = 'RSRC_ID';
    const PROP_NAME = 'PROP_NAME';
    const PROP_FRIENDLY_NAME = 'PROP_FRIENDLY_NAME';

    public static function PROP_ID() {
        return constant("self::PROP_ID");
    }

    public static function RSRC_ID() {
        return constant("self::RSRC_ID");
    }

    public static function PROP_NAME() {
        return constant("self::PROP_NAME");
    }

    public static function PROP_FRIENDLY_NAME() {
        return constant("self::PROP_FRIENDLY_NAME");
    }


}