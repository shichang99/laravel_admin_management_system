<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusLimitTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'bonus_limit_id',
        'user_id',
        'amount',
        'opening_balance',
        'closing_balance',
    ];
}
