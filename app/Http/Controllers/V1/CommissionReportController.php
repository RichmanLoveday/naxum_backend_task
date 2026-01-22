<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CommissionReportResource;
use App\Services\Commision\Interfaces\CommissionServiceInterface;
use Illuminate\Http\Request;

class CommissionReportController extends Controller
{
    protected CommissionServiceInterface $commissionService;

    public function __construct(CommissionServiceInterface $commissionService)
    {
        $this->commissionService = $commissionService;
    }


    public function index(Request $request)
    {
        $filters = $request->only([
            'distributor',
            'invoice',
            'start_date',
            'end_date',
        ]);

        try {
            $reports = $this->commissionService->getCommissionReports($filters);

            return CommissionReportResource::collection($reports);
        } catch (\Throwable $e) {

            logger()->error('Commission report failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Unable to fetch commission report',
            ], 500);
        }
    }
}