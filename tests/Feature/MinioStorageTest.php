<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;


class MinioStorageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_should_upload_file_to_minio(): void
    {
        $disk = Storage::disk('minio');
        $fileName = 'integration-test-' . now()->timestamp . '.txt';
        $content = 'Testing direct connection to MinIO server';

        $upload = $disk->put($fileName, $content);

        $this->assertTrue($upload);

        $this->assertTrue($disk->exists($fileName));

        $this->assertEquals($content, $disk->get($fileName));

        $disk->delete($fileName);
    }
}
