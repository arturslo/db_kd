<?php

namespace App\ProductType;

use Illuminate\Support\Facades\DB;

class ProductTypeRepository
{
    public function create(ProductType $productType): int
    {
        $sql = "INSERT INTO `ProductType` (`ProductTypeId`, `Name`) VALUES (:ProductTypeId, :Name);";
        DB::insert($sql, $productType->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }

    public function getOne(int $ProductTypeId)
    {
        $sql = "SELECT * FROM `ProductType` WHERE ProductTypeId=:ProductTypeId";
        $rows = DB::select($sql, ['ProductTypeId' => $ProductTypeId,]);

        $productTypes = array_map(function ($row) {
            return new ProductType(...(array)$row);
        }, $rows);

        $productType = null;
        if (isset($productTypes[0])) {
            $productType = $productTypes[0];
        }

        return $productType;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM `ProductType`";
        $rows = DB::select($sql);

        $productTypes = array_map(function ($row) {
            return new ProductType(...(array)$row);
        }, $rows);

        return $productTypes;
    }
}
