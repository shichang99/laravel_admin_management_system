<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class Ranking extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [ 'name' ];
}
