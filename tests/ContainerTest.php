<?php

namespace Tests;

use App\Support\Container;
use League\Container\Container as DiContainer;
use PHPUnit_Framework_TestCase;
use Tests\Fake\DependencyTest;

/**
 * Class ContainerTest
 *
 * @package Tests
 */
class ContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    private $container;

    public function setUp()
    {
        $this->container = new Container(new DiContainer(), '.');
    }

    /**
     * Test the auto wiring dependency injection
     */
    public function testDependencyInjection()
    {
        $this->assertInstanceOf(DependencyTest::class, $this->container->get(DependencyTest::class));
    }
}
