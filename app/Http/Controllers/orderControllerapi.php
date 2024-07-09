<?php

namespace App\Http\Controllers;
use App\Models\orderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderControllerapi extends Controller
{
    public function ReadOrder()
    {
        return orderModel::all();
    }
    public function GetOrder()
    {
        $orders = DB::table('orders')
            ->select('orders.*', 'products.product_name','products.price', 'customers.name', 'payment_methods.method_name')
            ->join('products', 'orders.products_id','=','products.products_id')
            ->join('customers', 'orders.customers_id','=','customers.customers_id')
            ->join('payment_methods', 'orders.payment_methods_id','=','payment_methods.payment_methods_id')
            ->orderBy('orders_id','DESC')
            ->get();
        return response()->json($orders); 
    }

    public function AddOrder(Request $request)
    {
        $products_id = $request->input('products_id');
        $customers_id = $request->input('customers_id');
        $payment_methods_id = $request->input('payment_methods_id');
        $orders_status_id = $request->input('orders_status_id');
        $order_date = $request->input('order_date');
        $total = $request->input('total');

        $result = DB::table('orders')->insert([
            'products_id' => $products_id,
            'customers_id' => $customers_id,
            'payment_methods_id' => $payment_methods_id,
            'orders_status_id' => $orders_status_id,
            'order_date' => $order_date,
            'total' => $total
        ]);

        return $result 
            ? response()->json(['message' => 'Success!'], 201)
            : response()->json(['message' => 'Fail!'], 500);
    }

    public function EditOrder(Request $request, $id)
    {
        $products_id = $request->input('products_id');
        $customers_id = $request->input('customers_id');
        $payment_methods_id = $request->input('payment_methods_id');
        $orders_status_id = $request->input('orders_status_id');
        $order_date = $request->input('order_date');
        $total = $request->input('total');

        $result = DB::table('orders')
            ->where('orders_id', $id)
            ->update([
                'products_id' => $products_id,
                'customers_id' => $customers_id,
                'payment_methods_id' => $payment_methods_id,
                'orders_status_id' => $orders_status_id,
                'order_date' => $order_date,
                'total' => $total
            ]);

        return $result 
            ? response()->json(['message' => 'Success!'])
            : response()->json(['message' => 'Fail!'], 500);
    }

    public function DeleteOrder($id)
    {
        $result = DB::table('orders')
            ->where('orders_id', $id)
            ->delete();

        return $result 
            ? response()->json(['message' => 'Delete success!'])
            : response()->json(['message' => 'Not found by id'], 404);
    }
}