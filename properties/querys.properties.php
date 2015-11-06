<?php

function select_all_devices()
{
    return "SELECT ID, MDL_ID, DVC_NAME, DVC_DESCRIPTION, DVC_UDN, DVC_TYPE, DVC_MANUFACTURER, DVC_MANUFACTURER_URL,
                   DVC_SERIAL_NUMBER, DVC_UPC, DVC_VERSION_MAJOR, DVC_VERSION_MINOR, DVC_XML_URI
            FROM DEVICES WHERE DELETED = 0";
}

function select_all_services()
{
    return "SELECT ID, SVAR_ID, SRVC_NAME, SRVC_DESCRIPTION, SRVC_TYPE, SRVC_SCPDURL,
                   SRVC_CONTROL_URL,SRVC_EVENT_SUD_URL
            FROM SERVICES WHERE DELETED = 0";
}

function select_all_actions()
{
    return "SELECT ID, SRVC_ID, ACT_NAME
            FROM ACTIONS WHERE DELETED = 0";
}

function select_all_slave_controllers()
{
    return "SELECT ID, MCON_ID, SCON_UNIQUE_NAME, SCON_DESCRIPTION
            FROM SLAVE_CONTROLLERS WHERE DELETED = 0";
}

function select_all_state_variables()
{
    return "SELECT ID, SVAR_NAME, SVAR_SEND_EVENT, SVAR_MULTICAST
            FROM STATE_VARIABLES WHERE DELETED = 0";
}

function select_all_resources()
{
    return "SELECT RSRC_NAME
            FROM META_RESOURCES";
}


//querys select by id
function select_device_by_id($id)
{
    return "SELECT  ID, MDL_ID, DVC_NAME, DVC_DESCRIPTION, DVC_UDN, DVC_TYPE, DVC_MANUFACTURER, DVC_MANUFACTURER_URL,
                    DVC_SERIAL_NUMBER, DVC_UPC, DVC_VERSION_MAJOR, DVC_VERSION_MINOR, DVC_XML_URI
            FROM DEVICES WHERE ID = '{$id}' AND DELETED = 0";
}

function select_service_by_id($id)
{
    return "SELECT ID, SVAR_ID, SRVC_NAME, SRVC_DESCRIPTION, SRVC_TYPE, SRVC_SCPDURL,
                   SRVC_CONTROL_URL,SRVC_EVENT_SUD_URL
            FROM SERVICES WHERE ID = '{$id}' AND DELETED = 0";
}

function select_action_by_id($id)
{
    return "SELECT ID, SRVC_ID, ACT_NAME
            FROM ACTIONS WHERE ID = '{$id}' AND DELETED = 0;";
}

function select_slave_controller_by_id($id)
{
    return "SELECT ID, MCON_ID, SCON_UNIQUE_NAME, SCON_DESCRIPTION
            FROM SLAVE_CONTROLLERS WHERE ID = '{$id}' AND DELETED = 0";
}

function select_state_variable_by_id($id)
{
    return "SELECT ID, SVAR_NAME, SVAR_SEND_EVENT, SVAR_MULTICAST
            FROM STATE_VARIABLES WHERE ID = '{$id}' AND DELETED = 0";
}

function select_resource_by_id($id)
{
    return "SELECT RSRC_NAME
            FROM META_RESOURCES WHERE ID = '{$id}'";
}


//querys select associeted resource
function select_device_services($dvc_id)
{
    return "SELECT SRVC_ID
            FROM DEVICE_SERVICES WHERE DVC_ID = '{$dvc_id}' AND DELETED = 0";
}

function select_service_actions($srvc_id)
{
    return "SELECT ID,SRVC_ID, ACT_NAME
            FROM ACTIONS WHERE SRVC_ID = '{$srvc_id}' AND DELETED = 0";
}

function select_service_state_variable($srvc_id)
{
    return "SELECT SVAR_ID
            FROM SERVICES WHERE ID = '{$srvc_id}' AND DELETED = 0";
}

function select_slave_controller_devices($scon_id)
{
    return "";
}

