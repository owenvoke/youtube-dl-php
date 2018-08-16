<?php

namespace pxgamer\YDP;

use PHPUnit\Framework\TestCase;

/**
 * Class DownloaderInfoTest
 */
class DownloaderInfoTest extends TestCase
{
    /**
     * @var Downloader
     */
    private $downloader;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->downloader = new Downloader('rfOY8ePOs_0');
    }

    /**
     * @test
     * @return void
     */
    public function itCanRetrieveTheVideoIdForAVideo()
    {
        $this->assertEquals(
            'rfOY8ePOs_0',
            $this->downloader->info['video_id']
        );
    }

    /**
     * @test
     * @return void
     */
    public function itCanRetrieveTheTitleForAVideo()
    {
        $this->assertEquals(
            'funny video, cant stop laughing,short funny videos',
            $this->downloader->info['title']
        );
    }

    /**
     * @test
     * @return void
     */
    public function itCanRetrieveTheKeywordsForAVideo()
    {
        $this->assertArrayHasKey(
            'keywords',
            $this->downloader->info
        );
        $this->assertEquals(
            'funny video,cant stop launghing',
            $this->downloader->info['keywords']
        );
    }

    /**
     * @test
     * @return void
     */
    public function itCanRetrieveTheUrlEncodedFmtStreamMap()
    {
        $this->assertArrayHasKey(
            'url_encoded_fmt_stream_map',
            $this->downloader->info
        );
    }
}
