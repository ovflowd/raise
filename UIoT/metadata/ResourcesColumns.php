<?php

namespace UIoT\metadata;

/**
 * Class Resources
 *
 * @package UIoT\metadata
 */
final class Resources
{
    const ID = 'ID';
    const RSRC_ACRONYM = 'RSRC_ACRONYM';
    const RSRC_NAME = 'RSRC_NAME';
    const RSRC_FRIENDLY_NAME = 'RSRC_FRIENDLY_NAME';

    public static function ID() {
        return constant('self::ID');
    }

    public static function RSRC_ACRONYM() {
        return constant('self::RSRC_ACRONYM');
    }

    public static function RSRC_NAME() {
        return constant('self::RSRC_NAME');
    }

    public static function RSRC_FRIENDLY_NAME() {
        return constant ('self::RSRC_FRIENDLY_NAME');
    }
}