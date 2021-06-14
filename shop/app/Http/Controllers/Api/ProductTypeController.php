<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ProductType\ProductTypeRepository;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index(Request $request, ProductTypeRepository $productTypeRepository)
    {
        return $productTypeRepository->getAll();
    }
}
