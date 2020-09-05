<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicacao extends Model
{
    protected $table = 'indicacaos';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
