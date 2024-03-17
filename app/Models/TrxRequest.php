<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Helper;

class TrxRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approved_by',
        'rejected_by',
        'reference',
        'txid',
        'wallet_type',
        'withdraw_method',
        'member_bank_detail',
        'original_amount',
        'original_process_fee',
        'currency_rate',
        'convert_amount',
        'convert_process_fee',
        'remark',
        'status',
        'approved_at',
        'rejected_at',
    ];

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function wallet() {
        return $this->belongsTo( MemberWallet::class, 'wallet_type' );
    }

    public function getOriginalActualAmountAttribute() {
        return Helper::currencyFormat( $this->attributes['original_amount'] - $this->attributes['original_process_fee'] , 4 );
    }
}
