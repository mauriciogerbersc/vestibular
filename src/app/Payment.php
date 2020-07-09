<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{

    use LogsActivity;

    protected $table = "payments";

    protected $fillable = ['reference', 'codigo', 'status_transacao', 'tipo_transacao'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static $logName = 'Payment';
    protected static $logAttributes = ['reference', 'codigo', 'status_transacao', 'tipo_transacao'];
    
}