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

namespace UIoT\Interfaces;

/**
 * Interface PropertyInterface
 *
 * A Resource Property internally is a `column` of a Resource
 * Publicly a Resource Property it's a Data Value of a Resource.
 * Each Resource has different sets of Properties.
 *
 * Only the Friendly Name of each Property are delivered to a `client`
 * and the RAISE only identifies a requested Property by their Friendly Name.
 *
 * @package UIoT\Interfaces
 */
interface PropertyInterface
{
    /**
     * Return the unique Database Property Identification <ID>
     *
     * The Property Id does'nt have any relations with other tables.
     * The Property Id only deserves for `META_PROPERTIES` table identification as a Primary Key.
     *
     * @return int
     */
    public function getId();

    /**
     * Return the Resource Unique Identification that the Property is linked.
     *
     * Each property necessary need be linked with a specific Resource,
     * since the Properties are the relations between a specific Resource Column set
     * with what can be asked from that Resource.
     *
     * @example <Devices> Table has a specific set of columns (Properties).
     * But only the properties listed in <META_PROPERTIES> with the Resource Id of Devices,
     * will be populated in RAISE.
     *
     * @return int
     */
    public function getResourceId();

    /**
     * Returns the Property Internal Name
     *
     * The Property Internal Name is only used in business logic inside RAISE
     * The Internal Name is used to to the Relations in Queries an other business logic
     *
     * @return string
     */
    public function getInternalName();

    /**
     * Returns the Property Friendly Name
     *
     * A Property Friendly Name is the public identification delivered to a `client`
     * about a Resource.
     *
     * Properties in a Request can be used as `Criteria's` for a Request, as example
     * in a `GET` method Request, Properties are used to filter the return set of Data
     * from a Resource. In `POST` method Properties are used as which columns you want insert
     * in a Resource Table.
     *
     * Only the friendly name is available for a `client`
     *
     * @return string
     */
    public function getFriendlyName();
}
