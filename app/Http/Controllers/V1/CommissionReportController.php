<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CommissionReportItemsResource;
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
            // get all reports for a commission
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


    public function getItems(Request $request, string|int $orderId)
    {
        // dd($orderId);
        try {
            // get items attached to a commision report
            $reportsItems = $this->commissionService->getReportItems($orderId);
            // dd($reportsItems->toArray());

            return CommissionReportItemsResource::collection($reportsItems);
        } catch (\Throwable $e) {
            logger()->error('Commission report items failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Unable to fetch commission report items',
            ], 500);
        }
    }
}