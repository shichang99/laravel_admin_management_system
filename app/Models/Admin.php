<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'role',
        'status',
        'password',
        'created_by',
        'updated_by',
    ];

    protected static $logAttributes = [
        'name',
        'email',
        'role',
        'status',
        'password',
        'created_by',
        'updated_by',
    ];

    protected static $logName = 'admins';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} admin";
    }
}
