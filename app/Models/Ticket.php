<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Ticket
 *
 * @property-read Category $category
 * @property-read TicketMessage[]|Collection $messages
 * @property-read string $number
 */
class Ticket extends Model
{
    protected $guarded = [];

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getNumberAttribute(): string
    {
        return $this->category->slug . '-Ticket-' . Str::padLeft('0', 3, $this->id);
    }
}
