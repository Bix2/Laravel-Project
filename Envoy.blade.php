@servers(['web' => ['deploybot@212.111.41.86']])

@setup
$account = 'deploybot';
@endsetup

@task('deploy-production', ['on' => 'web'])

cd /home/{{ $account }}/Laravel-Project

php artisan down 

git pull origin master --force

composer install

npm install

php artisan migrate

php artisan up

@endtask

