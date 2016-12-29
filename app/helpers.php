<?php

namespace App;

use App\Support\Container;

/**
 * Contains quick global helper methods
 * These are simple wrappers to more complex objects that need to be accessed
 * frequently within the application
 */

/**
 * Get a value out of the provided array using dot-notation
 *
 * @param array  $data
 * @param string $path
 * @return mixed|null
 */
function array_get(&$data, $path)
{
    foreach (explode('.', $path) as $key) {
        if (!is_array($data) || !array_key_exists($key, $data)) {
            // path has stopped
            return null;
        }
        $data = &$data[$key];
    }

    return $data;
}

/**
 * Retrieve an instance of the application Container
 *
 * @return Container
 */
function app()
{
    return Container::instance();
}

/**
 * Get the absolute path to the resource, based on the root of the application
 *
 * @param  string $relPath
 * @return string
 */
function path($relPath = null)
{
    $path = app()->root();
    if ($relPath !== null) {
        $path .= trim($relPath, ' /');
    }

    return $path;
}
