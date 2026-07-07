<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Train;
use Illuminate\Database\Seeder;

class TrainSeeder extends Seeder
{
    private array $seatCols = ['A', 'B', 'C', 'D'];

    public function run(): void
    {
        $trains = [
            [
                'code' => 'ARGO-BROMO',
                'name' => 'Argo Bromo Anggrek',
                'carriages' => [
                    ['class' => 'executive', 'name' => 'Eksekutif 1', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 2', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 3', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 4', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 5', 'capacity' => 50],
                ],
            ],
            [
                'code' => 'ARGO-LAWU',
                'name' => 'Argo Lawu',
                'carriages' => [
                    ['class' => 'executive', 'name' => 'Eksekutif 1', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 2', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 3', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 4', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 5', 'capacity' => 50],
                ],
            ],
            [
                'code' => 'TAKSAKA',
                'name' => 'Taksaka',
                'carriages' => [
                    ['class' => 'executive', 'name' => 'Eksekutif 1', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 2', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 3', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 4', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 5', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 6', 'capacity' => 50],
                ],
            ],
            [
                'code' => 'ARGO-PARAHYANGAN',
                'name' => 'Argo Parahyangan',
                'carriages' => [
                    ['class' => 'executive', 'name' => 'Eksekutif 1', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 2', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 3', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 4', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 5', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 6', 'capacity' => 50],
                ],
            ],
            [
                'code' => 'BIMA',
                'name' => 'Bima',
                'carriages' => [
                    ['class' => 'executive', 'name' => 'Eksekutif 1', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 2', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 3', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 4', 'capacity' => 50],
                    ['class' => 'business', 'name' => 'Bisnis 1', 'capacity' => 64],
                    ['class' => 'business', 'name' => 'Bisnis 2', 'capacity' => 64],
                ],
            ],
            [
                'code' => 'GAJAYANA',
                'name' => 'Gajayana',
                'carriages' => [
                    ['class' => 'executive', 'name' => 'Eksekutif 1', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 2', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 3', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 4', 'capacity' => 50],
                    ['class' => 'executive', 'name' => 'Eksekutif 5', 'capacity' => 50],
                ],
            ],
            [
                'code' => 'LODAYA',
                'name' => 'Lodaya',
                'carriages' => [
                    ['class' => 'business', 'name' => 'Bisnis 1', 'capacity' => 64],
                    ['class' => 'business', 'name' => 'Bisnis 2', 'capacity' => 64],
                    ['class' => 'business', 'name' => 'Bisnis 3', 'capacity' => 64],
                    ['class' => 'economy', 'name' => 'Ekonomi 1', 'capacity' => 80],
                    ['class' => 'economy', 'name' => 'Ekonomi 2', 'capacity' => 80],
                    ['class' => 'economy', 'name' => 'Ekonomi 3', 'capacity' => 80],
                    ['class' => 'economy', 'name' => 'Ekonomi 4', 'capacity' => 80],
                ],
            ],
        ];

        foreach ($trains as $data) {
            $train = Train::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'status' => 'active',
            ]);

            foreach ($data['carriages'] as $carriageData) {
                $carriage = $train->carriages()->create($carriageData);

                $seats = [];
                $count = 0;

                for ($row = 1; $count < $carriageData['capacity']; $row++) {
                    foreach ($this->seatCols as $col) {
                        if ($count >= $carriageData['capacity']) {
                            break;
                        }

                        $seats[] = [
                            'carriage_id' => $carriage->id,
                            'seat_number' => $row.$col,
                            'status' => 'available',
                        ];

                        $count++;
                    }
                }

                Seat::insert($seats);
            }
        }
    }
}
