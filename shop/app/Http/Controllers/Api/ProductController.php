<?php

namespace App\Http\Controllers\Api;

use App\Product\Product;
use App\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ProductController
{
    public function index(Request $request, ProductRepository $productRepository)
    {
        $ProductTypeId = $request->query('ProductTypeId');
        if ($ProductTypeId) {
            $products = $productRepository->getByType($ProductTypeId);
        } else {
            $products = $productRepository->getAll();
        }

        foreach ($products as $product) {
            $product->loadRelatedRowCount();
        }

        return $products;
    }

    public function show($id, ProductRepository $productRepository)
    {
        return $productRepository->getOne($id);
    }

    public function update($id, Request $request, ProductRepository $productRepository)
    {
        $rules = [
            'ProductTypeId' => 'required',
            'ProductName' => 'required',
            'ABV' => 'required',
            'Price' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        $validated = $validator->validate();
        $validated['ProductNo'] = $id;

        $product = new Product(...$validated);
        $productRepository->update($product);

        return response(['status' => 'ok']);
    }

    public function store(Request $request, ProductRepository $productRepository)
    {
        $rules = [
            'ProductNo' => 'required|unique:Product',
            'ProductTypeId' => 'required',
            'ProductName' => 'required',
            'ABV' => 'required',
            'Price' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        $validated = $validator->validate();

        $product = new Product(...$validated);
        $ProductNo = $productRepository->create($product);

        return response(['status' => 'ok', 'ProductNo' => $ProductNo]);
    }

    public function destroy($id, ProductRepository $productRepository)
    {
        $product = $productRepository->getOne($id);

        $errors = new MessageBag();
        if ($product === null) {
            $errors->add('global', 'Product not found');

            return response(['errors' => $errors], 422);
        }

        $product->loadRelatedRowCount();
        if ($product->RelatedRows['Total'] > 0) {
            $errors->add('global', 'Product has related entities');

            return response(['errors' => $errors], 422);
        }

        $productRepository->delete($product);

        return response(['status' => 'ok']);
    }
}
