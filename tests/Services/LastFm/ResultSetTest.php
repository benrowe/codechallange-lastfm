<?php

namespace Tests\Services\LastFm;

use App\Services\LastFm\Client;
use App\Services\LastFm\Response\ResultSet;

class ResultSetTest extends \PHPUnit_Framework_TestCase
{
    public function testInteration()
    {
        $data = range(0, 10, 2);
        $result = new ResultSet($data, new Client('', ''));

        $this->assertCount(count($data), $result);

        foreach ($data as $i => $value) {
            $this->assertSame($value, $result[$i]);
        }

        // iterate through the result set
        $loop = 0;
        foreach ($result as $i => $int) {
            $loop++;
        }
        $this->assertSame(count($data), $loop);

    }
}
