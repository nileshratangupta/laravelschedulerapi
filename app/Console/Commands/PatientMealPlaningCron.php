<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\PatientMealPlanningController;

class PatientMealPlaningCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patientmealplaning:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'description:regular intervals (5mins)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = now()->subYear();
        $endDate = now();
        $request = new FormRequest();
        $request->merge(['start_date' => $startDate->toDateString(), 'end_date' => $endDate->toDateString()]);
        app(PatientMealPlanningController::class)->getMealPlanningByDate($request);
        Log::info('regular intervals at range: ' . $startDate . ' to ' . $endDate);
    }
}
