<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\TestResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDownloadTest extends TestCase
{
    use WithFaker;

    /**
     * Tests File downloading
     *
     * @return void
     */
    public function testFileDownloading()
    {

        $response = $this->call('POST', '/', [
            'url' => $this->faker->imageUrl(600, 600)
        ]);

        $this->assertEquals(302, $response->status());
    }

    /**
     * Tests File List retrieval
     *
     * @return void
     */
    public function testFilesList()
    {

        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }

    /**
     * Tests File Downloading
     *
     * @return void
     */
    public function testFileDownload()
    {
        $filesResponse = $this->call('GET', '/');

        $file = $filesResponse->original->files->first();

        $response = $this->call('GET', "/download/$file->id");

        if ($response->baseResponse instanceof StreamedResponse) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    /**
     * Tests Faild Download
     *
     * @return void
     */
    public function testFaildDownload()
    {
        $filesResponse = $this->call('GET', '/');

        $response = $this->call('GET', "/download/5557575757575757");

        if ($response->baseResponse instanceof StreamedResponse) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

}
