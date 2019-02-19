<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'remember_token',
        'facebook_id',
    ];

    /**
     * Get the scancodes of the user.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scancode()
    {
        return $this->hasMany(ScanCode::class);
    }
}
