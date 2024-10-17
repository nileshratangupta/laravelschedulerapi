<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PatientMealPlanning;

class PatientMealPlanningController extends Controller
{
    public function getMealPlanningByDate(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $mealPlans = PatientMealPlanning::whereBetween('planned_date', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(planned_date)'), DB::raw('MONTH(planned_date)'))
            ->select(
                DB::raw('YEAR(planned_date) as year'),
                DB::raw('MONTH(planned_date) as month'),
                DB::raw('AVG(total_calories) as avg_total_calories'),
                DB::raw('AVG(total_carbs) as avg_total_carbs'),
                DB::raw('AVG(total_proteins) as avg_total_proteins'),
                DB::raw('AVG(total_fats) as avg_total_fats'),
                DB::raw('COUNT(DISTINCT planned_date) as planned_days'),
                DB::raw('DATEDIFF(MAX(planned_date), MIN(planned_date)) + 1 as total_days')
            )
            ->get();

        $response = [];
        
        foreach ($mealPlans as $plan) {
            $plannedPercentage = ($plan->planned_days / $plan->total_days) * 100;
            
            $skippedDays = DB::table('patient_meal_planning')
                ->whereYear('planned_date', $plan->year)
                ->whereMonth('planned_date', $plan->month)
                ->pluck('planned_date')
                ->toArray();

            $allDays = Carbon::parse($plan->year . '-' . $plan->month . '-01')->daysInMonth;
            $skippedDaysFormatted = [];

            for ($day = 1; $day <= $allDays; $day++) {
                $date = Carbon::createFromDate($plan->year, $plan->month, $day);
                if (!in_array($date->toDateString(), $skippedDays)) {
                    $skippedDaysFormatted[] = $date->format('d F Y');
                }
            }

            $response[] = [
                'month' => $date->format('F Y'),
                'planned_percentage' => round($plannedPercentage, 2) . ' %',
                'avg_total_calories' => round($plan->avg_total_calories),
                'avg_total_carbs' => round($plan->avg_total_carbs),
                'avg_total_proteins' => round($plan->avg_total_proteins),
                'avg_total_fats' => round($plan->avg_total_fats),
                'days_planning_skipped' => $skippedDaysFormatted,
            ];
        }

        return response()->json(['data' => $response]);
    }
}
