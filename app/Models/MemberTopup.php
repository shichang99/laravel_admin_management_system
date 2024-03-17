<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'updated_by',
        'type',
        'wallet_type',
        'payment_method',
        'amount',
        'convert_amount',
        'currency_rate',
        'attachment',
        'remark',
        'status',
    ];
    
    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }
}
