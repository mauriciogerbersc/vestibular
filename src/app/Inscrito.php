<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Inscrito extends Model
{   
    use LogsActivity;
    protected $table = 'inscritos';

    protected $guarded = ['id', 'created_at', 'updated_at'];


    protected static $logName = 'Inscrito';
    protected static $logAttributes = ['status', 'id'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
