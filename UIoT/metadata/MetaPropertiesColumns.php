<?php

namespace UIoT\metadata;

/**
 * Class MetaPropertiesColumns
 * @package UIoT\metadata
 */
final class MetaPropertiesColumns
{
    /**
     * @var string Property Id
     */
    private static $propertyId = 'ID';

    /**
     * @var string Resource Id
     */
    private static $resourceId = 'RSRC_ID';

    /**
     * @var string Property Name
     */
    private static $propertyName = 'PROP_NAME';

    /**
     * @var string Property Friendly Name
     */
    private static $propertyFriendlyName = 'PROP_FRIENDLY_NAME';

    /**
     * Get Property Id Column Name
     *
     * @return string
     */
    public static function getPropertyId()
    {
        return self::$propertyId;
    }

    /**
     * Get Resource Id Column Name
     *
     * @return string
     */
    public static function getResourceId()
    {
        return self::$resourceId;
    }

    /**
     * Get Property Name Column Name
     *
     * @return string
     */
    public static function getPropertyName()
    {
        return self::$propertyName;
    }

    /**
     * Get Property Friendly Name Column Name
     *
     * @return string
     */
    public static function getPropertyFriendlyName()
    {
        return self::$propertyFriendlyName;
    }
}
