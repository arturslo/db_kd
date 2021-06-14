<?php

namespace App\BankPayment;

use Illuminate\Support\Facades\DB;

class BankPaymentRepository
{
    public function create(BankPayment $bankPayment): int
    {
        $sql = "INSERT INTO `BankPayment` (`BankPaymentId`, `OrderNo`, `Amount`, `Status`) VALUES (:BankPaymentId, :OrderNo, :Amount, :Status);";
        DB::insert($sql, $bankPayment->toArray());
        $id = (int)DB::getPdo()->lastInsertId();

        return $id;
    }
}
