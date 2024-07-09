<?php

namespace App\Http\Controllers;
use App\Models\orderDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class orderDetailControllerapi extends Controller
{
    public function ReadOrderDetail()
    {
        return orderDetailModel::all();
    }

    public function GetOrderDetail()
    {
        return DB::table('order_details')->get();
    }

    public function AddOrderDetail(Request $request)
    {
        $orders_id = $request->input('orders_id');
        $products_id = $request->input('products_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        $result = DB::table('order_details')->insert([
            'orders_id' => $orders_id,
            'products_id' => $products_id,
            'quantity' => $quantity,
            'price' => $price
        ]);

        return $result 
            ? response()->json(['message' => 'Success!'], 201)
            : response()->json(['message' => 'Fail!'], 500);
    }

    public function EditOrderDetail(Request $request, $id)
    {
        $orders_id = $request->input('orders_id');
        $products_id = $request->input('products_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        $result = DB::table('order_details')
            ->where('order_details_id', $id)
            ->update([
                'orders_id' => $orders_id,
                'products_id' => $products_id,
                'quantity' => $quantity,
                'price' => $price
            ]);

        return $result 
            ? response()->json(['message' => 'Success!'])
            : response()->json(['message' => 'Fail!'], 500);
    }

    public function DeleteOrderDetail($id)
    {
        $result = DB::table('order_details')
            ->where('order_details_id', $id)
            ->delete();

        return $result 
            ? response()->json(['message' => 'Delete success!'])
            : response()->json(['message' => 'Not found by id'], 404);
    }
}