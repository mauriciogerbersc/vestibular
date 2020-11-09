<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivo extends Model
{
    protected $table = "processoSeletivo";
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
