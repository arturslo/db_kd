<?php

namespace App\Order;

use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function create(Order $order): int
    {
        $sql = "INSERT INTO `Order` (`OrderNo`, `BasketId`, `CreatedAt`, `Status`) VALUES (:OrderNo, :BasketId, :CreatedAt, :Status);";
        DB::insert($sql, $order->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }
}
