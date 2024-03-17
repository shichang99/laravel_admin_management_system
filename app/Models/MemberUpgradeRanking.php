<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberUpgradeRanking extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'user_id',
        'old_ranking',
        'new_ranking',
        'is_auto',
    ];
}
