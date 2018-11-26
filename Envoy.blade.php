@servers(['web' => ['deploybot@172.104.251.143']])

@setup
$account = 'deploybot';
@endsetup

@task('deploy-production', ['on' => 'web'])

cd /home/{{ $account }}/codebreak/Laravel-Project

php artisan down 

git pull origin master --force

composer install

npm install

php artisan migrate

php artisan up

@endtask

