<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MemberWallet extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'user_id',
        'balance',
        'type',
    ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    protected static $logAttributes = [
        'user_id',
        'balance',
        'type',
    ];

    protected static $logName = 'member_wallets';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} member wallet";
    }
}
