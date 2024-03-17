<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullname',
        'phone_number',
        'deposit_usdt_address',
        'withdrawal_usdt_address',
    ];

    protected static $logAttributes = [ '*'];

    protected static $logName = 'member_details';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} member detail";
    }
}
