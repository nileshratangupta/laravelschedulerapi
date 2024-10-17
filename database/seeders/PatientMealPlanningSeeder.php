<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PatientMealPlanning;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;

class PatientMealPlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::pluck('id');
        $users = User::pluck('id');

        foreach ($patients as $patient_id) {
            $used_dates = [];
            $planned_dates = [];
            for ($i = 0; $i < 500; $i++) {
                $planned_dates[] = Carbon::now()->subYears(2)->addDays(rand(0, 730))->toDateString();
            }
            $planned_dates = array_unique($planned_dates);
            foreach ($planned_dates as $planned_date) {
                PatientMealPlanning::create([
                    'patient_id' => $patient_id,
                    'planned_date' => $planned_date,
                    'total_calories' => rand(1000, 2500),
                    'total_fats' => rand(50, 100),
                    'total_carbs' => rand(150, 300),
                    'total_proteins' => rand(50, 150),
                    'is_active' => true,
                    'created_by' => $users->random(),
                    'updated_by' => $users->random(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
