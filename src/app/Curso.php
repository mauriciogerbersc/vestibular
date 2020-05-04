<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['curso', 'status', 'descricao', 'slug', 'imagem_curso', 'tipo_curso'];

    public function inscritos()
    {
        return $this->hasMany(Inscrito::class);
    }

}
