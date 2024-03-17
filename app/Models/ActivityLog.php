<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    public function admin() {
        return $this->belongsTo( Admin::class, 'causer_id' );
    }

    public function user() {
        return $this->belongsTo( User::class, 'causer_id' );
    }

    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    protected static $logAttributes = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    protected static $logName = 'activity_log';

    protected static $logOnlyDirty = true;

}
