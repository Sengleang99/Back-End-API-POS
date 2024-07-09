<?php

namespace App\Http\Controllers;

use App\Models\productModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productControllerapi extends Controller
{
    public function GetAllProduct()
    {
        $products = DB::table('products')
        ->join('categories', 'products.categories_id', '=', 'categories.categories_id')
        ->select('products.*', 'categories.categories_name')
        ->orderBy('products_id', 'DESC')
        ->get();
    return response()->json($products); 
    }

    public function GetProduct(Request $rq)
    {
        $products = DB::table('products')->get();
        return response()->json($products);
    }

    public function AddProduct(Request $rq)
    {
        $product_name = $rq->input('product_name');
        $description = $rq->input('description');
        $price = $rq->input('price');
        $categories_id = $rq->input('categories_id');
        $stock_quantity = $rq->input('stock_quantity');

        $result = DB::table('products')->insert([
            'product_name' => $product_name,
            'description' => $description,
            'price' => $price,
            'categories_id' => $categories_id,
            'stock_quantity' => $stock_quantity
        ]);

        return $result ? response()->json(['message' => 'Success!'], 201) : response()->json(['message' => 'Fail!'], 500);
    }

    public function EditProduct(Request $rq, $id)
    {
        $product_name = $rq->input('product_name');
        $description = $rq->input('description');
        $price = $rq->input('price');
        $categories_id = $rq->input('categories_id');
        $stock_quantity = $rq->input('stock_quantity');

        $result = DB::table('products')
            ->where('products_id', $id)
            ->update([
                'product_name' => $product_name,
                'description' => $description,
                'price' => $price,
                'categories_id' => $categories_id,
                'stock_quantity' => $stock_quantity
            ]);

        return $result ? response()->json(['message' => 'Success!']) : response()->json(['message' => 'Fail!'], 500);
    }

    public function DeleteProduct($id)
    {
        $result = DB::table('products')->where('products_id', $id)->delete();

        return $result ? response()->json(['message' => 'Delete success!']) : response()->json(['message' => 'Not found by id'], 404);
    }
}