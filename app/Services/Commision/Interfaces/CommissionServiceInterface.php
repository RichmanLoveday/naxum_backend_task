<?php

namespace App\Services\Commision\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface CommissionServiceInterface
{
    // Define method to get commission reports
    public function getCommissionReports(array $filteres);
}
