<?php

namespace UIoT\metadata;

/**
 * Class MetaDataTables
 * @package UIoT\metadata
 */
final class MetaDataTables
{
    /**
     * @var string Meta Resources Table Name
     */
    private static $metaResources = 'META_RESOURCES';

    /**
     * @var string Meta Properties Table Name
     */
    private static $metaProperties = 'META_PROPERTIES';

    /**
     * @var string Meta Permissions Table Name
     */
    private static $metaPermissions = 'META_PERMISSIONS';

    /**
     * Get Meta Resources Table Name
     *
     * @return string
     */
    public static function getMetaResourceName()
    {
        return self::$metaResources;
    }

    /**
     * Get Meta Properties Table Name
     *
     * @return string
     */
    public static function getMetaPropertiesName()
    {
        return self::$metaProperties;
    }

    /**
     * Get Meta Permissions Table Name
     *
     * @return string
     */
    public static function getMetaPermissionsName()
    {
        return self::$metaPermissions;
    }
}
