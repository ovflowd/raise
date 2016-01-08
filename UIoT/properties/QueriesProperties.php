<?php

namespace UIoT\properties;

/**
 * Returns a SQL query that selects all DEVICES from the database.
 *
 * @return string
 */
function selectAllDevices()
{
    return "SELECT ID, DVC_NAME, DVC_DESCRIPTION, DVC_UDN, DVC_TYPE, DVC_MANUFACTURER, DVC_MANUFACTURER_URL,
                   DVC_SERIAL_NUMBER, DVC_UPC, DVC_VERSION_MAJOR, DVC_VERSION_MINOR, DVC_XML_URI
            FROM DEVICES WHERE DELETED = 0";
}

/**
 * Returns a SQL query that selects all SERVICES from the database.
 *
 * @return string
 */
function selectAllServices()
{
    return "SELECT ID, SRVC_NAME, SRVC_DESCRIPTION, SRVC_TYPE, SRVC_SCPDURL,
                   SRVC_CONTROL_URL,SRVC_EVENT_SUD_URL
            FROM SERVICES WHERE DELETED = 0";
}

/**
 * Returns a SQL query that selects all ACTIONS from the database.
 *
 * @return string
 */
function selectAllActions()
{
    return "SELECT ID, ACT_NAME
            FROM ACTIONS WHERE DELETED = 0";
}

/**
 * Returns a SQL query that selects all SLAVE_CONTROLLERS in the database.
 *
 * @return string
 */
function selectAllSlaveControllers()
{
    return "SELECT ID, SCON_UNIQUE_NAME, SCON_DESCRIPTION
            FROM SLAVE_CONTROLLERS WHERE DELETED = 0";
}

/**
 * Returns a SQL query that selects all STATE_VARIABLES in the database.
 *
 * @return string
 */
function selectAllStateVariables()
{
    return "SELECT ID, SVAR_NAME, SVAR_SEND_EVENT, SVAR_MULTICAST
            FROM STATE_VARIABLES WHERE DELETED = 0";
}

/**
 * Returns a SQL query that selects all META_RESOURCES in the database.
 *
 * @return string
 */
function selectAllResources()
{
    return "SELECT RSRC_NAME, RSRC_FRIENDLY_NAME
            FROM META_RESOURCES";
}


//queries select by id
/**
 * Returns a SQL query that selects a device (DEVICES table) based on it's ID.
 * 
 * @param int $id
 * @return string
 */
function selectDeviceById($id)
{
    return "SELECT  ID, DVC_NAME, DVC_DESCRIPTION, DVC_UDN, DVC_TYPE, DVC_MANUFACTURER, DVC_MANUFACTURER_URL,
                    DVC_SERIAL_NUMBER, DVC_UPC, DVC_VERSION_MAJOR, DVC_VERSION_MINOR, DVC_XML_URI
            FROM DEVICES WHERE ID = '{$id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects a service (SERVICES table) based on it's ID.
 * 
 * @param int $id
 * @return string
 */
function selectServiceById($id)
{
    return "SELECT ID, SRVC_NAME, SRVC_DESCRIPTION, SRVC_TYPE, SRVC_SCPDURL,
                   SRVC_CONTROL_URL,SRVC_EVENT_SUD_URL
            FROM SERVICES WHERE ID = '{$id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects an action (ACTIONS table) based on it's ID.
 * 
 * @param int $id
 * @return string
 */
function selectActionById($id)
{
    return "SELECT ID, ACT_NAME
            FROM ACTIONS WHERE ID = '{$id}' AND DELETED = 0;";
}

/**
 * Returns a SQL query that selects a slave controller (SLAVE_CONTROLLERS table) based on it's ID.
 * 
 * @param int $id
 * @return string
 */
function selectSlaveControllerById($id)
{
    return "SELECT ID, SCON_UNIQUE_NAME, SCON_DESCRIPTION
            FROM SLAVE_CONTROLLERS WHERE ID = '{$id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects a state variable (STATE_VARIABLES table) based on it's ID.
 * 
 * @param int $id
 * @return string
 */
function selectStateVariableById($id)
{
    return "SELECT ID, SVAR_NAME, SVAR_SEND_EVENT, SVAR_MULTICAST
            FROM STATE_VARIABLES WHERE ID = '{$id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects a resource (META_RESOURCES table) based on it's ID.
 *
 * @param int $id
 * @return string
 */
function selectResourceById($id)
{
    return "SELECT RSRC_NAME
            FROM META_RESOURCES WHERE ID = '{$id}'";
}


//queries select associated resource
/**
 * Returns a SQL query that selects all SERVICES associated to a device (DEVICES table).
 *
 * @param int $dvc_id
 * @return string
 */
function selectDeviceServices($dvc_id)
{
    return "SELECT SRVC_ID
            FROM DEVICE_SERVICES WHERE DVC_ID = '{$dvc_id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects all ACTIONS associated to a service (SERVICES table).
 *
 * @param int $srvc_id
 * @return string
 */
function selectServiceActions($srvc_id)
{
    return "SELECT ACT_ID
            FROM SERVICE_ACTIONS WHERE SRVC_ID = '{$srvc_id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects all STATE_VARIABLES associated to a service (SERVICES table).
 *
 * @param int $srvc_id
 * @return string
 */
function selectServiceStateVariables($srvc_id)
{
    return "SELECT SVAR_ID
            FROM SERVICE_STATES WHERE SRVC_ID = '{$srvc_id}' AND DELETED = 0";
}

/**
 * Returns a SQL query that selects all DEVICES associated to slave controller (SLAVE_CONTROLLERS table).
 *
 * @param int $scon_id
 * @return string
 */
function selectSlaveControllerDevices($scon_id)
{
    return "SELECT DVC_ID
            FROM SLAVE_DEVICES WHERE SCON_ID = '{$scon_id}' AND DELETED = 0";
}
