<?php

namespace UIoT\metadata;

/**
 * Class Resources
 * @package UIoT\metadata
 */
final class MetaResourcesColumns
{
    /**
     * @var string Resource Id
     */
    private static $resourceId = 'ID';

    /**
     * @var string Resource Acronym Name
     */
    private static $resourceAcronym = 'RSRC_ACRONYM';

    /**
     * @var string Resource Name
     */
    private static $resourceName = 'RSRC_NAME';

    /**
     * @var string Resource Friendly Name
     */
    private static $resourceFriendlyName = 'RSRC_FRIENDLY_NAME';

    /**
     * Return Resource Id Column Name
     *
     * @return string
     */
    public static function getResourceId()
    {
        return self::$resourceId;
    }

    /**
     * Return Resource Acronym Column Name
     *
     * @return string
     */
    public static function getResourceAcronym()
    {
        return self::$resourceAcronym;
    }

    /**
     * Return Resource Name Column Name
     *
     * @return string
     */
    public static function getResourceName()
    {
        return self::$resourceName;
    }

    /**
     * Return Resource Friendly Name Column Name
     *
     * @return string
     */
    public static function getResourceFriendlyName()
    {
        return self::$resourceFriendlyName;
    }
}
