<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBonusTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by',
        'updated_by',
        'opening_balance',
        'amount',
        'closing_balance',
        'remark',
        'type',
        'status',
    ];
}
