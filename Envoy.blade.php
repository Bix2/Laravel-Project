@servers(['localhost' => '127.0.0.1])

@task('deploy:production', ['on' => 'localhost'])

php artisan down

git pull origin master --force

php -dallow_url_fopen=1 composer.phar self-update

php -dallow_url_fopen=1 composer.phar install --prefer-dist --no-dev

php artisan migrate

php artisan up

@endtask