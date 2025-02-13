<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner');
    }
}
