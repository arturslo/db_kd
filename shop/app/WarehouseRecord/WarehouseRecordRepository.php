<?php

namespace App\WarehouseRecord;

use Illuminate\Support\Facades\DB;

class WarehouseRecordRepository
{
    public function create(WarehouseRecord $warehouseRecord): int
    {
        $sql = "INSERT INTO `WarehouseRecord` (`WarehouseRecordId`, `ProductNo`, `AmountChange`, `Comment`) VALUES (:WarehouseRecordId, :ProductNo, :AmountChange, :Comment);";
        DB::insert($sql, $warehouseRecord->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }

    public function productAmountInWarehouse(string $ProductNo): int
    {
        $sql = <<< EOF
SELECT SUM(AmountChange) as AmountInWarehouse
FROM `WarehouseRecord` WHERE ProductNo = :ProductNo
GROUP BY ProductNo
EOF;

        $result = DB::select($sql, ['ProductNo' => $ProductNo]);
        if (!isset($result[0])) {
            return 0;
        }

        $AmountInWarehouse = (int)($result[0])->AmountInWarehouse;

        return $AmountInWarehouse;
    }
}
