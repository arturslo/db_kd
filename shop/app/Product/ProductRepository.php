<?php

namespace App\Product;

use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class ProductRepository
{
    public function create(Product $product): string
    {
        $sql = "INSERT INTO `Product` (`ProductNo`, `ProductTypeId`, `ProductName`, `ABV`, `Price`) VALUES (:ProductNo, :ProductTypeId, :ProductName, :ABV, :Price);";
        DB::insert($sql, $product->toArray());

        return $product->ProductNo;
    }

    public function update(Product $product): void
    {
        $sql = "UPDATE `Product` SET `ProductTypeId` = :ProductTypeId, `ProductName` = :ProductName, `ABV` = :ABV, `Price` = :Price WHERE `Product`.`ProductNo` = :ProductNo;";
        DB::update($sql, $product->toArray());
    }

    public function getAll()
    {
        $sql = "SELECT * FROM `Product`";
        $rows = DB::select($sql);

        $products = array_map(function ($row) {
            return new Product(...(array)$row);
        }, $rows);

        return $products;
    }

    public function getOne(string $ProductNo): ?Product
    {
        $sql = "SELECT * FROM `Product` WHERE ProductNo=:ProductNo";
        $rows = DB::select($sql, ['ProductNo' => $ProductNo,]);

        $products = array_map(function ($row) {
            return new Product(...(array)$row);
        }, $rows);

        $product = null;
        if (isset($products[0])) {
            $product = $products[0];
        }

        return $product;
    }

    public function getByType(int $ProductTypeId)
    {
        $sql = "SELECT * FROM `Product` WHERE ProductTypeId=:ProductTypeId";
        $rows = DB::select($sql, ['ProductTypeId' => $ProductTypeId]);

        $products = array_map(function ($row) {
            return new Product(...(array)$row);
        }, $rows);

        return $products;
    }

    #[ArrayShape([
        "ProductNo" => "string",
        "WarehouseRecordCount" => "int",
        "BasketProductCount" => "int",
        "Total" => "int",
    ])]
    public function getRelatedRowCount(string $ProductNo): array
    {
        $sql = <<< EOF
            SELECT
                p.ProductNo,
                COALESCE(w.WarehouseRecordCount, 0) AS WarehouseRecordCount,
                COALESCE(bp.BasketProductCount, 0) AS BasketProductCount
            FROM Product AS p
            LEFT JOIN
            (
                SELECT
                    ProductNo,
                    COUNT(WarehouseRecord.ProductNo) AS WarehouseRecordCount
                FROM WarehouseRecord
                GROUP BY WarehouseRecord.ProductNo
            ) AS w
            ON p.ProductNo = w.ProductNo
            LEFT JOIN
            (
                SELECT
                    ProductNo,
                    COUNT(BasketProduct.ProductNo) AS BasketProductCount
                FROM BasketProduct
                GROUP BY BasketProduct.ProductNo
            ) AS bp
            ON p.ProductNo = bp.ProductNo
            WHERE p.ProductNo = :ProductNo
EOF;
        $rows = DB::select($sql, ['ProductNo' => $ProductNo]);

        $rowsMapped = array_map(function ($row) {
            return [
                'ProductNo' => $row->ProductNo,
                'WarehouseRecordCount' => $row->WarehouseRecordCount,
                'BasketProductCount' => $row->BasketProductCount,
                'Total' => $row->WarehouseRecordCount + $row->BasketProductCount,
            ];
        }, $rows);

        return $rowsMapped[0];
    }

    public function delete(Product $product): void
    {
        $sql = "DELETE FROM `Product` WHERE `Product`.`ProductNo` = :ProductNo";
        DB::delete($sql, ['ProductNo' => $product->ProductNo,]);
    }
}

