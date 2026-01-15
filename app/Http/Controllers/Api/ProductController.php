<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'description', 'price', 'stock', 'created_at')->get();
        
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
