<?php

namespace Tests;

use App\Models\Country;

class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testAll()
    {
        $result = Country::all();
        $this->assertTrue(count($result) > 0);
        $this->assertInstanceOf(Country::class, $result['au']);
        $this->assertSame('Australia', $result['au']->name);

    }

    public function testFind()
    {
        $result = Country::findById('au');
        $this->assertInstanceOf(Country::class, $result);
        $this->assertEquals('Australia', $result->name);
    }
}
