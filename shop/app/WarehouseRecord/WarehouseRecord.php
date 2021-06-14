<?php

namespace App\WarehouseRecord;

use Illuminate\Contracts\Support\Arrayable;

class WarehouseRecord implements Arrayable
{
    public ?int $WarehouseRecordId;
    public string $ProductNo;
    public int $AmountChange;
    public string $Comment;

    /**
     * WarehouseRecord constructor.
     * @param int|null $WarehouseRecordId
     * @param string $ProductNo
     * @param int $AmountChange
     * @param string $Comment
     */
    public function __construct(?int $WarehouseRecordId = null, string $ProductNo, int $AmountChange, string $Comment)
    {
        $this->WarehouseRecordId = $WarehouseRecordId;
        $this->ProductNo = $ProductNo;
        $this->AmountChange = $AmountChange;
        $this->Comment = $Comment;
    }

    public function toArray()
    {
        return [
            'WarehouseRecordId' => $this->WarehouseRecordId,
            'ProductNo' => $this->ProductNo,
            'AmountChange' => $this->AmountChange,
            'Comment' => $this->Comment,
        ];
    }
}
