## Laravel

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