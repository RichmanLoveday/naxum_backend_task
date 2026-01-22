<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\Commision\Interfaces\CommissionServiceInterface;
use Illuminate\Http\Request;

class CommissionReportController extends Controller
{
    public CommissionServiceInterface $commissionService;

    public function __construct(CommissionServiceInterface $commissionService)
    {
        $this->commissionService = $commissionService;
    }
}
