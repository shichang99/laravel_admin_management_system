<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'updated_by',
        'number',
        'meta_data',
        'status',
        'is_primary',
        'type',
    ];

    protected $appends = [
        'encrypted_id'
    ];

    public function getEncryptedIdAttribute() {
        return \Crypt::encryptString( $this->attributes['id'] );
    }
}
