@servers(['codebreak' => 'deploybot@212.111.41.86'])
@setup
    $account = 'deploybot';
@endsetup

@task('deploy', ['on' => '212.111.41.86'])

cd /home/deploybot/Laravel-Project

php artisan migrate

@endtask