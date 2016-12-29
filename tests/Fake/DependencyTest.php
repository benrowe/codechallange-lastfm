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
     * @param Simple $object
     */
    public function __construct(Simple $object)
    {
        $this->object = $object;
    }
}
