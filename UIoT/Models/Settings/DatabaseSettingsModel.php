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

namespace UIoT\Models\Settings;

use UIoT\Models\SettingsModel;

/**
 * Class DatabaseSettingsModel
 *
 * This Model contains Settings Block of
 * RAISE Database Connection Settings
 *
 * @package UIoT\Models\Settings
 */
final class DatabaseSettingsModel extends SettingsModel
{
    /**
     * Connection Host for MySQL
     *
     * @var string
     */
    public $hostName = 'localhost';

    /**
     * Connection Port for MySQL
     *
     * @var int
     */
    public $hostPort = 3306;

    /**
     * Connection User Name for MySQL
     *
     * @var string
     */
    public $connUser = 'root';

    /**
     * Connection User Password for MySQL
     *
     * @var string
     */
    public $connPass = '';

    /**
     * Connection Data Base for MySQL
     *
     * @var string
     */
    public $connDataBase = 'UIOT';

    /**
     * This method returns the unique identification of the Block Name
     *
     * @return string
     */
    public function getBlockName()
    {
        return 'database';
    }
}
