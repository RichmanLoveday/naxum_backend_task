<?php

namespace App\Repositories\Commission;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Repositories\Commission\Interfaces\OrderRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * method defined to get commission orders based on filters
     * @param array $filters
     * @return Collection|array
     */
    public function getCommisionOrders(array $filters): LengthAwarePaginator
    {
        $query = Order::query()
            ->with([
                'orderItems.product',
                'purchaser.distributor',
            ]);


        // apply filter for invoice_id
        if (!empty($filters['invoice'])) {
            $query->where('invoice_number', $filters['invoice']);
        }

        // dd("Repository", $query->get(), $filters);

        // apply filter for date ranges
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween(
                'order_date',
                [$filters['start_date'], $filters['end_date']]
            );
        }


        // apply filter for distrivuter id, first name, last name
        if (!empty($filters['distributor'])) {
            $query->whereHas('purchaser.distributor', function ($q) use ($filters) {
                $q->where('id', $filters['distributor'])
                    ->orWhere('first_name', 'like', '%' . $filters['distributor'] . '%')
                    ->orWhere('last_name', 'like', '%' . $filters['distributor'] . '%');
            });
        }


        return $query->paginate(
            $filters['per_page'] ?? 15,
        );
    }


    public function getRefreredDistributors(User|null $distributor, string $orderDate): int
    {
        if (!$distributor) return 0;

        return $distributor->referredCustomers()
            ->whereHas('categories', function ($q) {
                $q->where('name', 'Distributor');
            })
            ->where('enrolled_date', '<=', $orderDate) // check when they joined
            ->count();
    }



    public function getOrderItems(string|int $orderId): LengthAwarePaginator
    {
        return OrderItem::query()
            ->with(['product'])
            ->where('order_id', $orderId)
            ->paginate(15);
    }
}
