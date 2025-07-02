<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'participant_id',
        'participant_type',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function participant(): MorphTo
    {
        return $this->morphTo();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getUnreadCountAttribute()
    {
        return $this->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->count();
    }

    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }
}
