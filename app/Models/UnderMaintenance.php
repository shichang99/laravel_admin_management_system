<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class UnderMaintenance extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [ 'content' ];

    protected $fillable = [
        'created_by',
        'updated_by',
        'type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'day',
        'content',
        'status',
    ];

    protected static $logAttributes = [
        'created_by',
        'updated_by',
        'type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'day',
        'content',
        'status',
    ];

    protected $appends = [
        'encrypted_id'
    ];

    public function getEncryptedIdAttribute() {
        return \Crypt::encryptString( $this->attributes['id'] );
    }

    protected static $logName = 'maintenances';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} maintenance";
    }
}
