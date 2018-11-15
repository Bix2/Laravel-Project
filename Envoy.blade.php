@servers(['web' => ['deploybot@212.111.41.86']])

@setup
$account = 'deploybot';
@endsetup

@task('deploy-production', ['on' => 'web'])

cd /home/deploybot/Laravel-Project

git pull origin master

php artisan migrate

@endtask