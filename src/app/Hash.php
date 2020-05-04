<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hash extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
