<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VercelBlobDiskTest extends TestCase
{
    private const TOKEN = 'vercel_blob_rw_AbC123_secret';

    private function disk()
    {
        return Storage::build([
            'driver' => 'vercel-blob',
            'token' => self::TOKEN,
            'visibility' => 'public',
            'throw' => false,
        ]);
    }

    public function test_url_points_to_public_store(): void
    {
        $this->assertSame(
            'https://abc123.public.blob.vercel-storage.com/posters/a.jpg',
            $this->disk()->url('posters/a.jpg'),
        );
    }

    public function test_upload_puts_file_with_fixed_pathname(): void
    {
        Http::fake(['vercel.com/api/blob/*' => Http::response(['url' => 'x'])]);

        $path = $this->disk()->putFile('posters', UploadedFile::fake()->image('p.jpg'));

        $this->assertStringStartsWith('posters/', $path);
        Http::assertSent(fn (Request $r) => $r->method() === 'PUT'
            && str_contains($r->url(), 'pathname='.urlencode($path))
            && $r->hasHeader('Authorization', 'Bearer '.self::TOKEN)
            && $r->hasHeader('x-add-random-suffix', '0')
            && $r->hasHeader('x-vercel-blob-access', 'public'));
    }

    public function test_exists_and_delete(): void
    {
        $heads = Http::sequence()->push(['pathname' => 'a.jpg', 'size' => 3])->push([], 404)->push(['blobs' => []]);
        Http::fake(fn (Request $r) => str_ends_with($r->url(), '/delete') ? Http::response([]) : $heads($r));

        $disk = $this->disk();

        $this->assertTrue($disk->exists('a.jpg'));
        $this->assertFalse($disk->exists('a.jpg'));
        $this->assertTrue($disk->delete('a.jpg'));

        Http::assertSent(fn (Request $r) => $r->url() === 'https://vercel.com/api/blob/delete'
            && $r['urls'] === ['https://abc123.public.blob.vercel-storage.com/a.jpg']);
    }

    public function test_failed_upload_returns_false(): void
    {
        Http::fake(['*' => Http::response('nope', 403)]);

        $this->assertFalse($this->disk()->put('a.txt', 'abc'));
    }
}
