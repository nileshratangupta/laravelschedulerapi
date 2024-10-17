<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use Carbon\Carbon;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Patient::create([
                'first_name' => 'FirstPatient' . $i,
                'last_name' => 'lastPatient' . $i,
                'date_of_birth' => Carbon::now()->subYears(rand(18, 65)),
                'gender' => rand(0, 1) == 0 ? 'male' : 'female',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
