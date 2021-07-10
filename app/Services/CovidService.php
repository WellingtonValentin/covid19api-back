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
            if (!isset($return[$month['number']])) {
                $return[$month['number']] = [
                    'mes' => $month['name'],
                    'total' => $report['Cases'],
                ];
                continue;
            }

            $return[$month['number']]['total'] += $report['Cases'];
        }
        return $return;
    }

    private function getMonth($date): array
    {
        date_default_timezone_set('America/Sao_Paulo');
        setlocale(LC_TIME, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');

        $date = Carbon::create($date);
        return [ 'number' => intval($date->format('m')), 'name' => $date->formatLocalized('%B') ];
    }

    public function getConfirmedCases(): array
    {
        return self::treatResults();
    }
}
