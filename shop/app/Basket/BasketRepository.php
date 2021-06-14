<?php

namespace App\Basket;

use Illuminate\Support\Facades\DB;

class BasketRepository
{
    public function create(Basket $basket): int
    {
        $sql = "INSERT INTO `Basket` (`BasketId`, `ClientId`) VALUES (:BasketId, :ClientId);";
        DB::insert($sql, $basket->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }
}
