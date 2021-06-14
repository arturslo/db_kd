<?php


namespace App\BasketProduct;


use Illuminate\Contracts\Support\Arrayable;

class BasketProduct implements Arrayable
{
    public int $BasketId;
    public string $ProductNo;
    public int $Quantity;

    /**
     * BasketProduct constructor.
     * @param int $BasketId
     * @param string $ProductNo
     * @param int $Quantity
     */
    public function __construct(int $BasketId, string $ProductNo, int $Quantity)
    {
        $this->BasketId = $BasketId;
        $this->ProductNo = $ProductNo;
        $this->Quantity = $Quantity;
    }

    public function toArray()
    {
        return [
            'BasketId' => $this->BasketId,
            'ProductNo' => $this->ProductNo,
            'Quantity' => $this->Quantity,
        ];
    }
}
