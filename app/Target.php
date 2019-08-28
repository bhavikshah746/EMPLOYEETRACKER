<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['user_id','target_rate'];
}
