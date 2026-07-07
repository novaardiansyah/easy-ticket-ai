<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Train extends Model
{
    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    public function carriages(): HasMany
    {
        return $this->hasMany(TrainCarriage::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
