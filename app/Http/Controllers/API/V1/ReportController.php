<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportGenerateRequest;
use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\ReportRepositoryInterface;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return object
     */
    public function generateMonthlyReport(ReportGenerateRequest $request)
    {
        $result = $this->reportRepository->reportByDate($request);
        return jsonFormat($result,"successfully",200);

    }


}
