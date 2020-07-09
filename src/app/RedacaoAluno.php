<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RedacaoAluno extends Model
{

    use LogsActivity;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static $logName = 'RedacaoAluno';
    protected static $logAttributes = ['id', 'enviou_redacao', 'corrigido', 'redacao_id'];
    

    public function inscrito()
    {
        return $this->belongsTo(Inscrito::class);
    }
    
    public function redacao()
    {
        return $this->belongsTo(Redacao::class);
    }
}
