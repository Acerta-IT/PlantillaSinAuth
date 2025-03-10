<?php

namespace App\Services;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use NoahNxT\LaravelOpenHolidaysApi\OpenHolidaysApi;

class WorkingDaysCalculator
{
    private $holidayApi;

    public function __construct(OpenHolidaysApi $holidayApi)
    {
        $this->holidayApi = $holidayApi;
    }

    public function calculate(string $startDate, string $endDate): ?int
    {
        if (!$startDate || !$endDate) {
            return null;
        }

        try {
            $startDate = Carbon::parse($startDate)->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->format('Y-m-d');

            // Get holidays for Madrid, Spain
            $response = $this->holidayApi->holidays()
                ->publicHolidays(
                    'ES',       // Country code
                    'es',       // Language
                    $startDate, // Start date
                    $endDate,   // End date
                    'ES-MD'     // Region code (Madrid)
                );

            $holidays = $response->json();
            $holidayDates = $this->getHolidayDates($holidays);

            return $this->countWorkingDays($startDate, $endDate, $holidayDates);
        } catch (\Exception $e) {
            Log::error('Error calculating working days: ' . $e->getMessage());
            return null;
        }
    }

    private function getHolidayDates(array $publicHolidays): array
    {
        $holidayDates = collect($publicHolidays)
            ->pluck('startDate')
            ->toArray();

        // Add custom holidays from database
        $customHolidays = Holiday::all()
            ->map(fn($holiday) => $holiday->date->format('Y-m-d'))
            ->toArray();

        return array_merge($holidayDates, $customHolidays);
    }

    private function countWorkingDays(string $startDate, string $endDate, array $holidayDates): int
    {
        $totalDays = 0;
        $currentDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        while ($currentDate <= $endDate) {
            if ($currentDate->isWeekday() && !in_array($currentDate->format('Y-m-d'), $holidayDates)) {
                Log::info('Adding day: ' . $currentDate->format('Y-m-d'));
                $totalDays++;
            }
            $currentDate->addDay();
        }

        return $totalDays;
    }
}
