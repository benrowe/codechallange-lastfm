<?php

namespace App;

/**
 * Contains quick global helper methods
 */

/**
 * Get a value out of the provided array using dot-notation
 *
 * @param array $data
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