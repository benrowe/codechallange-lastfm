<?php

namespace Tests\Services\LastFm;

use App\Services\LastFm\Client as LastFmClient;
use App\Services\LastFm\Contracts\ResultSet;
use App\Services\LastFm\Response\Artist;
use App\Services\LastFm\SearchRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;

/**
 * LastFmTest
 * Test the LastFM API calls
 *
 * @package Tests\Services\LastFm
 */
class LastFmTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LastFmClient
     */
    private static $service;

    public static function setUpBeforeClass()
    {
        $client = new LastFmClient('', '');
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__.'/../../mocks/lastfm-search-artist')),
            new Response(200, [], file_get_contents(__DIR__.'/../../mocks/lastfm-artist')),
            new Response(200, [], file_get_contents(__DIR__.'/../../mocks/lastfm-error')),
        ]);

        $handler = HandlerStack::create($mock);

        $client->setHttpClient(new Client(['handler' => $handler]));

        self::$service = $client;
    }

    public function testSearchArtist()
    {
        $result = self::$service->artist->search(new SearchRequest(['artist' => 'Pink Floyd']));
        $this->assertInstanceOf(ResultSet::class, $result);
        $this->assertTrue(count($result) > 0);
        $this->assertInstanceOf(Artist::class, $result[0]);
    }

    public function testFindArtist()
    {
        $pinkFloydId = '83d91898-7763-47d7-b03b-b92132375c47';
        $result = self::$service->artist->find($pinkFloydId);
        $this->assertInstanceOf(Artist::class, $result);
        $this->assertEquals('Pink Floyd', $result->name);

        $this->assertSame(
            'https://lastfm-img2.akamaized.net/i/u/64s/a6ab3e76448f421e99c1f16d6d41e624.png',
            $result->image(Artist::IMAGE_SIZE_MEDIUM)
        );

        $this->assertFalse(self::$service->getArtist()->find('This artist could not exist!'));
    }

    public function testTopArtistGeo()
    {
        $result = self::$service->geo->topArtists('au');

        $this->assertInstanceOf(ResultSet::class, $result);
        $this->assertTrue(count($result) > 0);
        $this->assertInstanceOf(Artist::class, $result[0]);

    }
}
