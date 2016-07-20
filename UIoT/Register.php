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

use UIoT\Managers\InteractionManager as Interaction;

/* File Used to Register RAISe Interactions */
/* Only GENERIC Interactions MUST be Added Here */

/**
 * Add Search Interaction
 *
 * used to search Resource Items
 */
Interaction::getInstance()->add('SearchInteraction', 'GET');

/**
 * Add Insert Interaction
 *
 * used to Insert Resource Items
 */
Interaction::getInstance()->add('InsertInteraction', 'POST');
