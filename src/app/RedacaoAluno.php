<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedacaoAluno extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function inscrito()
    {
        return $this->belongsTo(Inscrito::class);
    }
    
    public function redacao()
    {
        return $this->belongsTo(Redacao::class);
    }
}
