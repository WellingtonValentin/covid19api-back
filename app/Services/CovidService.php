<?php

namespace App\Services;

use Carbon\Carbon;

class CovidService
{
    private $restService;

    /**
     * CovidService constructor.
     */
    public function __construct()
    {
        $this->restService = new RestService();
    }

    private function treatResults(): array
    {
        $return = [];
        $results = $this->restService->getResults();
        foreach ($results as $report) {
            $month = self::getMonth($report['Date']);
            if (!isset($return[$month])) {
                $return[$month] = [
                    'mes' => $month,
                    'total' => $report['Cases'],
                ];
                continue;
            }

            $return[$month]['total'] += $report['Cases'];
        }
        return $return;
    }

    private function getMonth($date): string
    {
        $date = Carbon::create($date);
        return $date->format('m');
    }

    public function getConfirmedCases(): array
    {
        return self::treatResults();
    }
}
