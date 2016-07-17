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

use UIoT\Mappers\Constants as C;

/* Add Meta Resources SELECT Query */
C::getInstance()->add('metaResourcesQuery',
    'SELECT META_RESOURCES.ID, 
      META_RESOURCES.RSRC_ACRONYM, 
      META_RESOURCES.RSRC_NAME, 
      META_RESOURCES.RSRC_FRIENDLY_NAME
     FROM META_RESOURCES');

/* Add Meta Properties SELECT Query */
C::getInstance()->add('metaPropertiesQuery',
    'SELECT META_PROPERTIES.ID, 
      META_PROPERTIES.RSRC_ID, 
      META_PROPERTIES.PROP_NAME, 
      META_PROPERTIES.PROP_FRIENDLY_NAME 
     FROM META_PROPERTIES');

/* Add RAISE Messages SELECT Query */
C::getInstance()->add('raiseMessagesQuery',
    'SELECT MESSAGES.ID, 
      MESSAGES.NAME, 
      MESSAGES.VALUE 
     FROM MESSAGES');

