<?php

/**
 * UIoT Service Layer
 * @version alpha
 *                          88
 *                          ""              ,d
 *                                          88
 *              88       88 88  ,adPPYba, MM88MMM
 *              88       88 88 a8"     "8a  88
 *              88       88 88 8b       d8  88
 *              "8a,   ,a88 88 "8a,   ,a8"  88,
 *               `"YbbdP'Y8 88  `"YbbdP"'   "Y888
 *
 * @author Universal Internet of Things
 * @license MIT <https://opensource.org/licenses/MIT>
 * @copyright University of Brasília
 */

use UIoT\Mappers\Constants;

/* Generic Queries */

/**
 * Add Meta Resources SELECT Query
 */
Constants::getInstance()->add('metaResourcesQuery',
    'SELECT META_RESOURCES.ID, 
      META_RESOURCES.RSRC_ACRONYM, 
      META_RESOURCES.RSRC_NAME, 
      META_RESOURCES.RSRC_FRIENDLY_NAME
     FROM META_RESOURCES');

/**
 * Add Meta Properties SELECT Query
 */
Constants::getInstance()->add('metaPropertiesQuery',
    'SELECT META_PROPERTIES.ID, 
      META_PROPERTIES.RSRC_ID, 
      META_PROPERTIES.PROP_NAME, 
      META_PROPERTIES.PROP_FRIENDLY_NAME 
     FROM META_PROPERTIES');

/**
 * Add RAISE Messages SELECT Query
 */
Constants::getInstance()->add('raiseMessagesQuery',
    'SELECT MESSAGES.ID, 
      MESSAGES.NAME, 
      MESSAGES.VALUE 
     FROM MESSAGES');

/**
 * Add RAISE Get Token Details SELECT Query
 */
Constants::getInstance()->add('tokenDetailsQuery',
    'SELECT DEVICE_TOKENS.DVC_ID, 
      DEVICE_TOKENS.DVC_TOKEN, 
      DEVICE_TOKENS.DVC_TOKEN_EXPIRE 
     FROM DEVICE_TOKENS');

/**
 * Add RAISE Create new Token INSERT Query
 * @var int DVC_ID
 * @var string DVC_TOKEN
 * @var int DVC_TOKEN_EXPIRE
 */
Constants::getInstance()->add('addTokenQuery',
    'INSERT INTO DEVICE_TOKENS (DVC_ID, DVC_TOKEN, DVC_TOKEN_EXPIRE) 
      VALUES (:DVC_ID, :DVC_TOKEN, :DVC_TOKEN_EXPIRE)');

/* Specific Queries */

/**
 * Get Specific Token Details
 * @var string DVC_TOKEN
 */
Constants::getInstance()->add('specificTokenDetailsQuery',
    Constants::getInstance()->get('tokenDetailsQuery') .
    ' WHERE DEVICE_TOKENS.DVC_TOKEN = :DVC_TOKEN');

/**
 * Get Specific Properties
 * @var int RSRC_ID
 */
Constants::getInstance()->add('specificPropertiesQuery',
    Constants::getInstance()->get('metaPropertiesQuery') .
    ' WHERE META_PROPERTIES.RSRC_ID = :RSRC_ID');

