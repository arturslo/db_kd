<?php

namespace App\Product;

use App\ProductType\ProductType;
use App\ProductType\ProductTypeRepository;
use App\WarehouseRecord\WarehouseRecordRepository;
use Illuminate\Contracts\Support\Arrayable;

class Product implements Arrayable
{
    public string $ProductNo;
    public int $ProductTypeId;
    public string $ProductName;
    public string $ABV;
    public string $Price;
    public ProductType $ProductType;
    public int $InStock;
    public ?array $RelatedRows;

    /**
     * Product constructor.
     * @param string $ProductNo
     * @param int $ProductTypeId
     * @param string $ProductName
     * @param string $ABV
     * @param string $Price
     */
    public function __construct(string $ProductNo, int $ProductTypeId, string $ProductName, string $ABV, string $Price)
    {
        $this->ProductNo = $ProductNo;
        $this->ProductTypeId = $ProductTypeId;
        $this->ProductName = $ProductName;
        $this->ABV = $ABV;
        $this->Price = $Price;
        $this->loadProductType();
        $this->loadProductAmountInWarehouse();
        $this->RelatedRows = null;
    }

    public function toArray()
    {
        return [
            'ProductNo' => $this->ProductNo,
            'ProductTypeId' => $this->ProductTypeId,
            'ProductName' => $this->ProductName,
            'ABV' => $this->ABV,
            'Price' => $this->Price,
        ];
    }

    private function loadProductType(): void
    {
        /** @var ProductTypeRepository $typeRepo */
        $typeRepo = app(ProductTypeRepository::class);

        $this->ProductType = $typeRepo->getOne($this->ProductTypeId);
    }

    public function loadProductAmountInWarehouse(): void
    {
        /** @var WarehouseRecordRepository $warehouseRepo */
        $warehouseRepo = app(WarehouseRecordRepository::class);

        $this->InStock = $warehouseRepo->productAmountInWarehouse($this->ProductNo);
    }

    public function loadRelatedRowCount(): void
    {
        /** @var ProductRepository $productRepository */
        $productRepository = app(ProductRepository::class);

        $this->RelatedRows = $productRepository->getRelatedRowCount($this->ProductNo);
    }
}
