<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Station extends Model
{
    protected $fillable = [
        'code',
        'name',
        'city',
        'address',
    ];

    public function routesAsOrigin(): HasMany
    {
        return $this->hasMany(Route::class, 'origin_station_id');
    }

    public function routesAsDestination(): HasMany
    {
        return $this->hasMany(Route::class, 'destination_station_id');
    }

    public function scheduleStops(): HasMany
    {
        return $this->hasMany(ScheduleStop::class);
    }
}
