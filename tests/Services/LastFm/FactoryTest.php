<?php
/**
 *
 */

namespace Tests\Services\LastFm;

use App\Services\LastFm\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $client = Factory::fromConfig(
            [
                'api_key'    => '12345',
                'api_secret' => 'secret',
                'pagination' => ['limit' => 100]
            ]
        );
        $this->assertSame('12345', $client->getApiKey());
        $this->assertArrayHasKey('pagination', $client->getOptions());
        $this->assertSame(100, $client->getOption('pagination.limit'));
    }
}
