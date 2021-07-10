<?php

namespace App\Http\Controllers;
use App\Services\CovidService;
use Illuminate\Http\Response;
use Exception;

class CovidController extends Controller
{
    public function getConfirmedCases()
    {
        try {
            $response = (new CovidService())->getConfirmedCases();
            return response($response, Response::HTTP_OK);
        } catch (Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }
    }
}
