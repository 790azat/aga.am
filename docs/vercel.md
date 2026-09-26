# Деплой на Vercel

Laravel на Vercel работает через community-runtime [vercel-php](https://github.com/vercel-community/php) (PHP 8.5).
Файловая система Vercel доступна только для чтения, поэтому понадобятся внешняя база и внешнее хранилище файлов.

## 1. База данных (Postgres)

В Vercel откройте **Storage → Create Database → Neon (Postgres)** и подключите базу к проекту.
Vercel сам добавит переменную `DATABASE_URL`, и сайт подхватит её автоматически, `DB_CONNECTION` и `DB_URL` задавать не нужно.

## 2. Хранилище файлов (Vercel Blob)

Постеры, видео и аватары хранятся в Vercel Blob: в проекте на Vercel откройте **Storage → Create Database → Blob**
и подключите хранилище к проекту. Vercel сам добавит `BLOB_READ_WRITE_TOKEN`, и сайт начнёт использовать Blob
после следующего деплоя. Ничего больше настраивать не нужно.

Вместо Blob можно использовать S3-совместимый бакет (например, Cloudflare R2): задайте переменные `AWS_*` из таблицы ниже.
Если заданы обе, используется Blob.

Старые файлы из `storage/app/public` (папки `posters`, `backgrounds`, `logos`, `videos`, `avatars`) нужно один раз
загрузить в хранилище с теми же путями.

## 3. Проект на Vercel

Импортируйте репозиторий на https://vercel.com/new (Framework Preset: **Other**, остальное возьмётся из `vercel.json`).
В **Settings → Environment Variables** добавьте:

| Переменная | Значение |
| --- | --- |
| `APP_KEY` | вывод `php artisan key:generate --show` |
| `APP_URL` | `https://<ваш-домен>` |
| `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY` | ключи R2 (только если не используете Blob) |
| `AWS_BUCKET` | имя бакета |
| `AWS_ENDPOINT` | `https://<account-id>.r2.cloudflarestorage.com` |
| `AWS_URL` | публичный адрес бакета |
| `AWS_DEFAULT_REGION` | `auto` |
| `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` | из Google Cloud Console |
| `GOOGLE_REDIRECT_URI` | `https://<ваш-домен>/auth/google/callback` |

`APP_KEY` обязателен: без него все страницы, кроме `/up`, отвечают 500 (`MissingAppKeyException`).
Пустые переменные считаются незаданными. Переменные из `.env.example` (`LOG_CHANNEL`, `SESSION_DRIVER` и т.п.) копировать не нужно.
После изменения переменных сделайте **Redeploy**: уже запущенный деплой новых значений не видит.

Остальные настройки (кэши в `/tmp`, логи в stderr, сессии в cookie) задаются в `api/index.php`.
Проверить живой сайт можно workflow `smoke` в GitHub Actions: он запускается после каждого пуша в `master`.

## 4. Миграции

В GitHub: **Settings → Secrets and variables → Actions** добавьте `PROD_DB_URL`, `PROD_APP_KEY` и `SEED_ADMIN_PASSWORD`,
затем запустите workflow **migrate** во вкладке Actions (галочка `seed` заполнит базу демо-данными).
