<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\Station;
use App\Models\Train;
use Illuminate\Database\Seeder;

class RouteAndScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $gmr = Station::where('code', 'GMR')->value('id');
        $bd = Station::where('code', 'BD')->value('id');
        $sgu = Station::where('code', 'SGU')->value('id');
        $yk = Station::where('code', 'YK')->value('id');
        $slo = Station::where('code', 'SLO')->value('id');
        $ml = Station::where('code', 'ML')->value('id');
        $cn = Station::where('code', 'CN')->value('id');
        $pwt = Station::where('code', 'PWT')->value('id');
        $smt = Station::where('code', 'SMT')->value('id');

        $routes = [
            [
                'origin' => $gmr, 'dest' => $sgu, 'km' => 790, 'min' => 540,
                'train' => 'ARGO-BROMO', 'price' => 550000,
                'departures' => ['08:00', '20:30'],
                'stops' => [$cn, $pwt, $yk, $slo, $smt],
            ],
            [
                'origin' => $gmr, 'dest' => $slo, 'km' => 570, 'min' => 420,
                'train' => 'ARGO-LAWU', 'price' => 450000,
                'departures' => ['09:00', '21:00'],
                'stops' => [$cn, $pwt, $yk],
            ],
            [
                'origin' => $gmr, 'dest' => $yk, 'km' => 520, 'min' => 420,
                'train' => 'TAKSAKA', 'price' => 400000,
                'departures' => ['08:30', '19:45'],
                'stops' => [$cn, $pwt],
            ],
            [
                'origin' => $gmr, 'dest' => $bd, 'km' => 180, 'min' => 180,
                'train' => 'ARGO-PARAHYANGAN', 'price' => 200000,
                'departures' => ['06:00', '09:30', '13:00', '16:30', '20:00'],
                'stops' => [],
            ],
            [
                'origin' => $gmr, 'dest' => $sgu, 'km' => 820, 'min' => 600,
                'train' => 'BIMA', 'price' => 500000,
                'departures' => ['07:30', '21:00'],
                'stops' => [$cn, $pwt, $yk, $slo, $smt],
            ],
            [
                'origin' => $gmr, 'dest' => $ml, 'km' => 880, 'min' => 660,
                'train' => 'GAJAYANA', 'price' => 600000,
                'departures' => ['09:30', '22:00'],
                'stops' => [$cn, $pwt, $yk, $smt, $sgu],
            ],
            [
                'origin' => $bd, 'dest' => $slo, 'km' => 520, 'min' => 480,
                'train' => 'LODAYA', 'price' => 300000,
                'departures' => ['07:00', '20:00'],
                'stops' => [$cn, $pwt, $yk],
            ],
        ];

        $today = now()->format('Y-m-d');

        foreach ($routes as $r) {
            $route = Route::create([
                'origin_station_id' => $r['origin'],
                'destination_station_id' => $r['dest'],
                'distance_km' => $r['km'],
                'estimated_duration' => $r['min'],
            ]);

            $train = Train::where('code', $r['train'])->first();

            foreach ($r['departures'] as $dep) {
                $departure = "{$today} {$dep}:00";
                $arrival = date('Y-m-d H:i:s', strtotime("{$departure} + {$r['min']} minutes"));

                $schedule = $route->schedules()->create([
                    'train_id' => $train->id,
                    'departure_time' => $departure,
                    'arrival_time' => $arrival,
                    'base_price' => $r['price'],
                ]);

                $interval = intval($r['min'] / (count($r['stops']) + 1));

                foreach ($r['stops'] as $i => $stop) {
                    $stopDeparture = date('Y-m-d H:i:s', strtotime("{$departure} + ".($interval * ($i + 1)).' minutes'));
                    $stopArrival = date('Y-m-d H:i:s', strtotime("{$stopDeparture} - 5 minutes"));

                    $schedule->stops()->create([
                        'station_id' => $stop,
                        'arrival_time' => $stopArrival,
                        'departure_time' => $stopDeparture,
                        'stop_order' => $i + 1,
                    ]);
                }
            }
        }
    }
}
