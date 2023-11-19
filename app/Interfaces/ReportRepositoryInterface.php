<?php

namespace App\Interfaces;


interface ReportRepositoryInterface
{
    /**
     * @param $request
     * @return object
     */
    public function reportByDate($request):object;
}
