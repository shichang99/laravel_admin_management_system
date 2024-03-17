<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasTranslations;

class Announcement extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [ 'title', 'message' ];

    protected $fillable = [
        'created_by',
        'update_by',
        'title',
        'message',
        'image',
        'type',
        'status',
    ];

    protected static $logAttributes = [
        'created_by',
        'update_by',
        'title',
        'message',
        'image',
        'type',
        'status',
    ];
    protected $appends = [
        'encrypted_id'
    ];

    protected static $logName = 'announcements';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} announcement";
    }
    public function getEncryptedIdAttribute() {
        return \Crypt::encryptString( $this->attributes['id'] );
    }
}
