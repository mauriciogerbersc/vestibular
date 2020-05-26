<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{   
    protected $table = "inscritoo";

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
