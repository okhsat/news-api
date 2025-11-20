# News Aggregator API with Laravel

## Project Overview

This project is a backend system for aggregating and serving articles. It provides data aggregation, storage, and API endpoints for frontend consumption.

---

### 1. Data Aggregation and Storage

Implement a backend system that:

- Fetches articles from selected data sources (**choose at least 3** from the provided list)
- Stores the articles locally in a database
- Regularly updates data from live sources to keep it fresh

**Requirements:**

- Data must be persisted in a database (e.g., MySQL, PostgreSQL, SQLite)
- Backend should handle updates and avoid duplicates
- Fetching should be scheduled (e.g., via cron job, queue system, or scheduler)

---

### 2. API Endpoints

Create RESTful API endpoints that allow the frontend to:

- Retrieve articles based on:
  - Search queries
  - Filtering criteria: date, category, source
  - User preferences: selected sources, categories, authors
- Support pagination and sorting

**Example Endpoints:**

```http
GET /api/articles?search=AI&category=Technology&source=TechCrunch
GET /api/articles?author=John+Doe&date=2025-11-20
```

## Commands

```bash
composer --version
node -v && npm -v
composer create-project laravel/laravel api
cd api
ls -l
git init
git add .
git commit -m "Initial News Aggregator API project"
git remote add origin git@github.com:okhsat/news-api.git
git branch -M master
git push -u origin master
php artisan key:generate
cat .env
composer install
touch database/database.sqlite
php artisan migrate
php artisan migrate:fresh
php artisan make:migration create_sources_table
php artisan make:migration create_categories_table
php artisan make:migration create_articles_table
php artisan make:migration create_sync_logs_table
php artisan make:model Source
php artisan make:model Category
php artisan make:model Article
php artisan make:model SyncLog
php artisan make:controller SourceController --api
php artisan make:controller CategoryController --api
php artisan make:controller ArticleController --api
php artisan make:controller SyncLogController --api
php artisan route:clear
php artisan route:list
mkdir -p app/Services/News
php artisan make:interface NewsSourceInterface
touch app/Services/News/NewsApiService.php
touch app/Services/News/GuardianService.php
touch app/Services/News/BbcService.php
php artisan make:job FetchArticlesJob
mkdir -p app/Console && touch app/Console/Kernel.php
sudo apt install sqlite3
php artisan tinker
touch database/seeders/SourcesTableSeeder.php
php artisan db:seed
sqlite3 database/database.sqlite
sqlite> .tables
sqlite> .schema sources
sqlite> select * from sources;
```

## License

The application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).