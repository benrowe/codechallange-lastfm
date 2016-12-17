<?php

/**
 *
 */

namespace Tests\Fake;

class DependencyTest
{
    public $object;

    /**
     * DependencyTest constructor.
     *
     * @param SimpleClass $object
     */
    public function __construct(Simple $object)
    {
        $this->object = $object;
    }
}
