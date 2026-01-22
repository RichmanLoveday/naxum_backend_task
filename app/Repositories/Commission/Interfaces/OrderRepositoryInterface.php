<?php

namespace App\Repositories\Commission\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    // method defined to get commission orders based on filters
    public function getCommisionOrders(array $filters): LengthAwarePaginator;
    public function getRefreredDistributors(User|Null $distributors, string $orderDate): int;
}
