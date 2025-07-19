<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $guarded = [];

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function cateogry(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
