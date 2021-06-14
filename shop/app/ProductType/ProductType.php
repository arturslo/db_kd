<?php


namespace App\ProductType;


use Illuminate\Contracts\Support\Arrayable;

class ProductType implements Arrayable
{
    public ?int $ProductTypeId;
    public string $Name;

    /**
     * ProductType constructor.
     * @param int|null $ProductTypeId
     * @param string $Name
     */
    public function __construct(?int $ProductTypeId = null, string $Name)
    {
        $this->ProductTypeId = $ProductTypeId;
        $this->Name = $Name;
    }


    public function toArray()
    {
        return [
            'ProductTypeId' => $this->ProductTypeId,
            'Name' => $this->Name,
        ];
    }
}
