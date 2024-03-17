<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MemberWalletTransaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'member_wallet_id',
        'user_id',
        'created_by',
        'updated_by',
        'amount',
        'opening_balance',
        'closing_balance',
        'remark',
        'type',
        'trx_type',
        'status',
    ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    protected static $logAttributes = [
        'member_wallet_id',
        'user_id',
        'created_by',
        'updated_by',
        'amount',
        'opening_balance',
        'closing_balance',
        'remark',
        'type',
        'trx_type',
        'status',
    ];

    protected $appends = [
        'converted_remark',
    ];

    public function getConvertedRemarkAttribute() {

        if ( str_contains( $this->attributes['remark'], '}##' ) ) {
            $a = explode( '}##', $this->attributes['remark'] );
            $remark = str_replace( '##{', '', $a[0] );
    
            return __( 'wallet.' . $remark ) . $a[1];
        }
        
        return $this->attributes['remark'];
    }

    protected static $logName = 'member_wallet_transactions';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} member wallet transaction";
    }
}
