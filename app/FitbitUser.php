<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FitbitUser extends Model
{
    protected $fillable = [
        'token', 'fitbit_id', 'name', 'avatar'
    ];
}
