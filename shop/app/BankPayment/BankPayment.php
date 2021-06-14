<?php

namespace App\BankPayment;

use Illuminate\Contracts\Support\Arrayable;

class BankPayment implements Arrayable
{
    public string $BankPaymentId;
    public string $OrderNo;
    public string $Amount;
    public string $Status;

    /**
     * BankPayment constructor.
     * @param string $BankPaymentId
     * @param string $OrderNo
     * @param string $Amount
     * @param string $Status
     */
    public function __construct(string $BankPaymentId, string $OrderNo, string $Amount, string $Status)
    {
        $this->BankPaymentId = $BankPaymentId;
        $this->OrderNo = $OrderNo;
        $this->Amount = $Amount;
        $this->Status = $Status;
    }

    public function toArray()
    {
        return [
            'BankPaymentId' => $this->BankPaymentId,
            'OrderNo' => $this->OrderNo,
            'Amount' => $this->Amount,
            'Status' => $this->Status,
        ];
    }
}
