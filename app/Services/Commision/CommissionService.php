<?php

namespace App\Services\Commision;

use App\Repositories\Commission\Interfaces\OrderRepositoryInterface;
use App\Services\Commision\Interfaces\CommissionServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CommissionService implements CommissionServiceInterface
{
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
    ) {}


    public function getCommissionReports(array $filters): LengthAwarePaginator
    {
        $orders = $this->orderRepository->getCommisionOrders($filters);

        // loop through orders and calculate commission
        $orders->map(function ($order) {
            $order->order_total = $order->orderItems->sum(function ($item) {
                $price = $item->product ? $item->product->price : 0;
                return $item->quantity * $price;
            });

            // dd($order->order_total);

            // distributors
            $distributor = $order->purchaser->distributor;

            // if no distributor set default values
            if (!$distributor) {
                $order->reffered_distributors = 0;
                $order->percentage = 0;
                $order->commission = 0;
                return $order;
            }

            // dd($distributor);

            // get refered distributors
            $order->reffered_distributors = $this->orderRepository
                ->getRefreredDistributors($distributor, $order->order_date);

            //dd($order->reffered_distributors);

            // calculate commission percentage based on number of items
            $order->percentage = $this->calculateCommision($order->reffered_distributors);

            //dd($order->percentage);

            // calculate commission amount
            $order->commission_amount = ($order->order_total * $order->percentage)
                / 100;

            // dd($order->commission_amount);
        });

        // dd($orders);
        return $orders;
    }


    public function getReportItems(string|int $orderId): LengthAwarePaginator
    {
        $orderItems = $this->orderRepository->getOrderItems($orderId);
        return $orderItems;
    }



    private function calculateCommision(int $count): int
    {
        switch (true) {
            case $count >= 30:
                return 30;
            case $count >= 21:
                return 20;
            case $count >= 11:
                return 15;
            case $count >= 5:
                return 10;
            default:
                return 5; // 0-4 distributors
        }
    }
}
