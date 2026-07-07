<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        $stations = [
            ['code' => 'GMR', 'name' => 'Gambir', 'city' => 'Jakarta', 'address' => 'Jl. Medan Merdeka Timur No. 1, Jakarta Pusat'],
            ['code' => 'PSE', 'name' => 'Pasar Senen', 'city' => 'Jakarta', 'address' => 'Jl. Stasiun Senen No. 1, Jakarta Pusat'],
            ['code' => 'BD', 'name' => 'Bandung', 'city' => 'Bandung', 'address' => 'Jl. Stasiun Timur No. 1, Bandung'],
            ['code' => 'SGU', 'name' => 'Surabaya Gubeng', 'city' => 'Surabaya', 'address' => 'Jl. Stasiun Gubeng No. 1, Surabaya'],
            ['code' => 'YK', 'name' => 'Yogyakarta', 'city' => 'Yogyakarta', 'address' => 'Jl. Margo Utomo No. 1, Yogyakarta'],
            ['code' => 'SMT', 'name' => 'Semarang Tawang', 'city' => 'Semarang', 'address' => 'Jl. Taman Stasiun No. 1, Semarang'],
            ['code' => 'ML', 'name' => 'Malang', 'city' => 'Malang', 'address' => 'Jl. Trunojoyo No. 1, Malang'],
            ['code' => 'SLO', 'name' => 'Solo Balapan', 'city' => 'Solo', 'address' => 'Jl. Revormasi No. 1, Solo'],
            ['code' => 'CN', 'name' => 'Cirebon', 'city' => 'Cirebon', 'address' => 'Jl. Stasiun No. 1, Cirebon'],
            ['code' => 'PWT', 'name' => 'Purwokerto', 'city' => 'Purwokerto', 'address' => 'Jl. Stasiun No. 1, Purwokerto'],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
}
