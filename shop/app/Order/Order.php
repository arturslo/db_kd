<?php

namespace App\Order;

use Illuminate\Contracts\Support\Arrayable;

class Order implements Arrayable
{

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    public const STATUS_CANCELED = 'CANCELED';
    public const STATUS_COMPLETED = 'COMPLETED';

    public string $OrderNo;
    public int $BasketId;
    public string $CreatedAt;
    public string $Status;

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PAID,
            self::STATUS_CANCELED,
            self::STATUS_COMPLETED,
        ];
    }

    /**
     * Order constructor.
     * @param string $OrderNo
     * @param int $BasketId
     * @param string $CreatedAt
     * @param string $Status
     */
    public function __construct(string $OrderNo, int $BasketId, string $CreatedAt, string $Status)
    {

        if (!in_array($Status, self::getStatuses())) {
            throw new \InvalidArgumentException('Status does not match allowed values');
        }

        $this->OrderNo = $OrderNo;
        $this->BasketId = $BasketId;
        $this->CreatedAt = $CreatedAt;
        $this->Status = $Status;
    }


    public function toArray()
    {
        return [
            'OrderNo' => $this->OrderNo,
            'BasketId' => $this->BasketId,
            'CreatedAt' => $this->CreatedAt,
            'Status' => $this->Status,
        ];
    }
}
