<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'message',
        'expiry',
        'created_at',
    ];

    /**
     * Get the decrypted message text.
     *
     * @return string
     */
    public function getTextAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set the message text to its encrypted form.
     *
     * @param  string  $value
     * @return void
     */
    public function setTextAttribute($value)
    {
        $this->attributes['text'] = encrypt($value);
    }

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}
