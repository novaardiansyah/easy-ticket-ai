<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    protected $fillable = [
        'carriage_id',
        'seat_number',
        'status',
    ];

    public function carriage(): BelongsTo
    {
        return $this->belongsTo(TrainCarriage::class, 'carriage_id');
    }

    public function passengers(): HasMany
    {
        return $this->hasMany(Passenger::class);
    }
}
