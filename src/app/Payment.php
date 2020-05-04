<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";

    protected $fillable = ['reference', 'codigo', 'status_transacao', 'tipo_transacao'];

    protected $guarded = ['id', 'created_at', 'updated_at'];
    
}