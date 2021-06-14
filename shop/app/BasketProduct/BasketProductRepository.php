<?php

namespace App\BasketProduct;

use Illuminate\Support\Facades\DB;

class BasketProductRepository
{
    public function create(BasketProduct $basketProduct): int
    {
        $sql = "INSERT INTO `BasketProduct` (`BasketId`, `ProductNo`, `Quantity`) VALUES (:BasketId, :ProductNo, :Quantity);";
        DB::insert($sql, $basketProduct->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }
}
