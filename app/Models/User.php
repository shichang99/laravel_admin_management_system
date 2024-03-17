<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_id',
        'ranking_id',
        'package_id',
        'sponsor_id',
        'name',
        'email',
        'password',
        'security_pin',
        'invitation_code',
        'sponsor_structure',
        'capital',
        'is_free_acc',
        'status',
        'created_by',
        'updated_by',
    ];

    public function memberDetail() {
        return $this->hasOne( MemberDetail::class, 'user_id' );
    }

    public function ranking() {
        return $this->belongsTo( Ranking::class, 'ranking_id' );
    }

    public function package() {
        return $this->belongsTo( Package::class, 'package_id' );
    }
    
    public function sponsor() {
        return $this->belongsTo( User::class, 'sponsor_id' );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'security_pin',
        'remember_token',
    ];

    protected $appends = [
        'encrypted_id'
    ];

    public function getEncryptedIdAttribute() {
        return \Crypt::encryptString( $this->attributes['id'] );
    }

    public function getTotalDirectSponsorAttribute() {
        return MemberStructure::where( 'sponsor_id', $this->attributes['id'] )->where( 'level', 1 )->count();
    }
    
    public function getTotalGroupAttribute() {
        return MemberStructure::where( 'sponsor_id', $this->attributes['id'] )->count();
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logAttributes = [ '*'];

    protected static $logName = 'users';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getDescriptionForEvent( string $eventName ): string {
        return "{$eventName} user";
    }
}
