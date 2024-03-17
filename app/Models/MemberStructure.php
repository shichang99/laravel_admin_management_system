<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MemberStructure extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'sponsor_id',
        'level'
    ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function sponsor() {
        return $this->belongsTo( User::class, 'sponsor_id' );
    }

    protected static $logAttributes = [
        'user_id',
        'sponsor_id',
        'level'
    ];

    protected static $logName = 'member_structures';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} member structure";
    }
}
