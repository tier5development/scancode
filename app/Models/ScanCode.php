<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanCode extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scancodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'facebook_page_id',
        'facebook_page_name',
        'scan_code_uri',
    ];

    /**
     * Set the scancode's user ID.
     *
     * @param  string  $value
     * @return void
     */
    public function setUserIdAttribute($value) {
        $userId = 1;
        if ($user = User::whereFacebookId($value)->first()) {
            $userId = $user->id;
        }
        $this->attributes['user_id'] = $userId;
    }

    /**
     * Get the user that owns the scancodes.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
