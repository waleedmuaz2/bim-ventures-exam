<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportGenerateRequest;
use App\Interfaces\ReportRepositoryInterface;

class ReportController extends Controller
{
    protected $reportRepository;
    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * Ger Report.
     *
     * @param ReportGenerateRequest $request
     * @return object
     */
    public function generateMonthlyReport(ReportGenerateRequest $request):object
    {
        return $this->reportRepository->reportByDate($request);
    }
}
