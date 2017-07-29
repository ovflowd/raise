<?php

/**
 *  _    _ _____   _______
 * | |  | |_   _| |__   __|
 * | |  | | | |  ___ | |
 * | |  | | | | / _ \| |
 * | |__| |_| || (_)|| |
 * \_____/|____\____/|_|.
 *
 * @author Universal Internet of Things
 * @license Apache 2 <https://opensource.org/licenses/Apache-2.0>
 * @copyright University of Brasília
 */

namespace App\Facades;

use App\Models\Communication\Model;
use App\Models\Communication\Raise as RaiseModel;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use JsonMapper;
use JsonMapper_Exception;
use UnexpectedValueException;

/**
 * Class View.
 *
 * A Facade that handles all views on raise
 *  (non jSON)
 *
 * @see https://en.wikipedia.org/wiki/Model–view–controller
 * @see https://en.wikipedia.org/wiki/Facade_pattern Documentation of the Pattern
 *
 * @version 2.0.0
 *
 * @since 2.0.0
 */
class View extends Facade
{
    public static function add(string $view)
    {

    }

    /**
     * Translate a view namespace unto valid view fs path
     *
     * @param string $view
     *
     * @return string
     */
    protected static function resolve(string $view)
    {
        return str_replace('.', '/', $view);
    }
}
