@servers(['production' => 'deploybot@172.104.146.141' ])

@setup
$account = 'deploybot';
@endsetup

@task('deploy-production', ['on' => 'production'])
cd /home/{{ $account }}/staging/Laravel-Project
php artisan down 
git reset --hard HEAD
git pull origin master --force
composer dump-autoload
composer install
npm install
php artisan migrate --force
php artisan up
@endtask

