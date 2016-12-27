<?php

namespace App\Services\LastFm\Contracts;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Interface ResultSet
 *
 * @package App\Services\LastFm
 */
interface ResultSet extends Countable, ArrayAccess, Iterator
{
}
