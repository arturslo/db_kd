<?php

namespace App\Basket;

use Illuminate\Contracts\Support\Arrayable;

class Basket implements Arrayable
{
    public ?int $BasketId;
    public int $ClientId;

    /**
     * Basket constructor.
     * @param int|null $BasketId
     * @param int $ClientId
     */
    public function __construct(?int $BasketId = null, int $ClientId)
    {
        $this->BasketId = $BasketId;
        $this->ClientId = $ClientId;
    }


    public function toArray()
    {
        return [
            'BasketId' => $this->BasketId,
            'ClientId' => $this->ClientId,
        ];
    }
}
