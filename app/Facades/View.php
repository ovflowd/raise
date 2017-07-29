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

use InvalidArgumentException;

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
    /**
     * The HTML content to be Rendered.
     *
     * @var string HTML content to be rendered
     */
    private static $content = '';

    /**
     * Includes a View unto the System.
     *
     * @param string $view  the view to be added
     * @param array  $parse variables to be parsed
     */
    public static function add(string $view, array $parse = [])
    {
        if (($resolve = self::resolve($view)) === false) {
            throw new InvalidArgumentException('View doesn\'t exists.');
        }

        self::$content .= self::parse(file_get_contents($resolve), $parse);

        response()::setContent(self::$content);
    }

    /**
     * Render and Return the HTML content.
     *
     * @param string $content content to be rendered
     *
     * @return string the rendered HTML content
     */
    public static function render(string $content)
    {
        return $content;
    }

    /**
     * Translate a view namespace unto valid view fs path.
     *
     * @param string $view the desired view
     *
     * @return string if the view exists return the complete path if not returns false
     */
    protected static function resolve(string $view)
    {
        $path = path('resources/views/').str_replace('.', '/', $view).'.php';

        return file_exists($path) ? $path : false;
    }

    /**
     * Basic Templating Engine to Parse Variables.
     *
     * @param string $content Content to be Parsed
     * @param array  $parse   What to Parse
     *
     * @return mixed|string Return the Parsed Content
     */
    protected static function parse(string $content, array $parse)
    {
        foreach ($parse as $key => $replace) {
            $content = str_replace($key, $replace, $content);
        }

        return $content;
    }
}
