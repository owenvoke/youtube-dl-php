<?php

namespace pxgamer\YDP;

use PHPUnit\Framework\TestCase;

/**
 * Class DownloaderTest
 */
class DownloaderTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function itCanParseAVideoUrlForYoutubeData()
    {
        $data = new Downloader('https://www.youtube.com/watch?v=rfOY8ePOs_0');

        $this->assertInstanceOf(Downloader::class, $data);
    }

    /**
     * @test
     * @return void
     */
    public function itCanParseAVideoIdForYoutubeData()
    {
        $data = new Downloader('rfOY8ePOs_0');

        $this->assertInstanceOf(Downloader::class, $data);
    }
}
