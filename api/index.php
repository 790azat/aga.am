<?php

/*
 * Точка входа для Vercel (runtime vercel-php).
 * Файловая система Vercel доступна на запись только в /tmp,
 * поэтому все кэши, скомпилированные шаблоны и storage уходят туда.
 */

$defaults = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'LARAVEL_STORAGE_PATH' => '/tmp/storage',
    'APP_CONFIG_CACHE' => '/tmp/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/cache/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/cache/services.php',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => 'cookie',
    'CACHE_STORE' => 'database',
    'QUEUE_CONNECTION' => 'sync',
    // Медиа в R2/S3, только если бакет настроен; иначе сайт падал бы на любой странице с постерами.
    'PUBLIC_DISK_DRIVER' => getenv('AWS_BUCKET') ? 's3' : 'local',
];

// Пустые переменные в Vercel считаем незаданными: иначе Laravel получает '' вместо значения
// по умолчанию (например, SESSION_DRIVER='' ломал все страницы).
foreach (getenv() as $key => $value) {
    if ($value === '') {
        putenv($key);
        unset($_ENV[$key], $_SERVER[$key]);
    }
}

foreach ($defaults as $key => $value) {
    if (getenv($key) === false) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $_SERVER[$key] = $value;
    }
}

// Логи только в stderr: их видно во вкладке Logs на Vercel (файлы в /tmp никто не прочитает).
putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = $_SERVER['LOG_CHANNEL'] = 'stderr';

// Фатальные ошибки PHP тоже пишем в лог Vercel.
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        error_log("PHP fatal: {$error['message']} at {$error['file']}:{$error['line']}");
    }
});

foreach (['/tmp/cache', '/tmp/storage/framework/views', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions', '/tmp/storage/logs', '/tmp/storage/app/public'] as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

require __DIR__.'/../public/index.php';
