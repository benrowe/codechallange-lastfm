<?php

namespace Tests\Services\LastFm;

use App\Services\LastFm\Support\Musicbrainz;
use PHPUnit_Framework_TestCase;

/**
 * Class MusicbrainzTest
 *
 * @package Tests\Services\LastFm
 */
class MusicbrainzTest extends PHPUnit_Framework_TestCase
{
    public function testVerifyId()
    {
        $this->assertTrue((new Musicbrainz())->isValidId('83d91898-7763-47d7-b03b-b92132375c47'));
        $this->assertFalse((new Musicbrainz())->isValidId(''));
        $this->assertFalse((new Musicbrainz())->isValidId('83d91898-7763-47d7-b03b'));
    }
}
