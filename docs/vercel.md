# Деплой на Vercel

Laravel на Vercel работает через community-runtime [vercel-php](https://github.com/vercel-community/php) (PHP 8.5).
Файловая система Vercel доступна только для чтения, поэтому понадобятся внешняя база и внешнее хранилище файлов.

## 1. База данных (Postgres)

В Vercel откройте **Storage → Create Database → Neon (Postgres)** и подключите базу к проекту.
Скопируйте строку подключения (`DATABASE_URL`).

## 2. Хранилище файлов (Cloudflare R2)

Постеры, видео и аватары загружаются в S3-совместимый бакет. Бесплатный вариант — Cloudflare R2:
создайте бакет, включите публичный доступ (r2.dev или свой домен) и API-токен с правами Object Read & Write.

Старые файлы из `storage/app/public` (папки `posters`, `backgrounds`, `logos`, `videos`, `avatars`) нужно один раз
загрузить в бакет с теми же путями.

## 3. Проект на Vercel

Импортируйте репозиторий на https://vercel.com/new (Framework Preset: **Other**, остальное возьмётся из `vercel.json`).
В **Settings → Environment Variables** добавьте:

| Переменная | Значение |
| --- | --- |
| `APP_KEY` | вывод `php artisan key:generate --show` |
| `APP_URL` | `https://<ваш-домен>` |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | строка подключения Neon |
| `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY` | ключи R2 |
| `AWS_BUCKET` | имя бакета |
| `AWS_ENDPOINT` | `https://<account-id>.r2.cloudflarestorage.com` |
| `AWS_URL` | публичный адрес бакета |
| `AWS_DEFAULT_REGION` | `auto` |
| `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET` | из Google Cloud Console |
| `GOOGLE_REDIRECT_URI` | `https://<ваш-домен>/auth/google/callback` |

Остальные настройки (кэши в `/tmp`, логи в stderr, сессии в cookie) задаются в `api/index.php`.

## 4. Миграции

В GitHub: **Settings → Secrets and variables → Actions** добавьте `PROD_DB_URL`, `PROD_APP_KEY` и `SEED_ADMIN_PASSWORD`,
затем запустите workflow **migrate** во вкладке Actions (галочка `seed` заполнит базу демо-данными).
