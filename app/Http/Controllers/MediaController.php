<?php

namespace App\Http\Controllers;

use App\Filesystem\VercelBlobAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Отдаёт файлы из приватного хранилища Vercel Blob (постеры, видео, аватары).
 */
class MediaController extends Controller
{
    // Ответ функции Vercel не может быть больше 4.5 МБ, поэтому видео отдаётся кусками.
    private const MAX_CHUNK = 4 * 1024 * 1024;

    // Заглушки для файлов, которых ещё нет в хранилище (например, не перенесённых со старого хостинга).
    private const PLACEHOLDERS = [
        'posters' => 'images/poster-placeholder.png',
        'backgrounds' => 'images/background-placeholder.png',
        'logos' => 'images/logo-placeholder.png',
        'avatars' => 'images/actor-placeholder.png',
    ];

    public function __invoke(Request $request, string $path)
    {
        $adapter = Storage::disk('public')->getAdapter();
        abort_unless($adapter instanceof VercelBlobAdapter, 404);
        abort_if(str_contains($path, '..'), 404);

        $blob = $adapter->fetch($path, $this->range($request->header('Range')));

        if ($blob->status() === 404 && $placeholder = self::PLACEHOLDERS[strstr($path, '/', true)] ?? null) {
            return redirect(asset($placeholder))->header('Cache-Control', 'public, max-age=300');
        }

        abort_unless(in_array($blob->status(), [200, 206], true), $blob->status() === 416 ? 416 : 404);

        $headers = array_filter([
            'Content-Type' => $blob->header('Content-Type') ?: 'application/octet-stream',
            'Content-Length' => $blob->header('Content-Length'),
            'Content-Range' => $blob->header('Content-Range'),
            'Accept-Ranges' => 'bytes',
            'ETag' => $blob->header('ETag'),
            'Last-Modified' => $blob->header('Last-Modified'),
            // Имена файлов уникальны (хэш), поэтому их можно кэшировать надолго, в том числе на CDN Vercel.
            'Cache-Control' => 'public, max-age=31536000, s-maxage=31536000, immutable',
        ]);

        $body = $blob->toPsrResponse()->getBody();

        return response()->stream(function () use ($body) {
            while (! $body->eof()) {
                echo $body->read(64 * 1024);
                flush();
            }
        }, $blob->status() === 206 ? Response::HTTP_PARTIAL_CONTENT : Response::HTTP_OK, $headers);
    }

    /**
     * Ограничивает запрошенный диапазон байт, чтобы ответ влез в лимит Vercel.
     */
    private function range(?string $header): ?string
    {
        if (! $header || ! preg_match('/^bytes=(\d+)-(\d*)$/', trim($header), $m)) {
            return null;
        }

        $start = (int) $m[1];
        $end = $m[2] === '' ? PHP_INT_MAX : (int) $m[2];

        return 'bytes='.$start.'-'.min($end, $start + self::MAX_CHUNK - 1);
    }
}
