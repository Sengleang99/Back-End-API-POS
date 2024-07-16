<?php

namespace App\Http\Controllers;
use App\Models\orderDetailModel;
use App\Models\orderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class orderControllerapi extends Controller
{
    public function ReadOrder()
    {
        return orderModel::all();
    }
    public function GetOrder()
    {
        $orders = DB::table('order')
            ->select('order.*', 'products.product_name','products.price', 'customers.name', 'payment_methods.method_name')
            ->join('products', 'orders.products_id','=','products.products_id')
            ->join('customers', 'orders.customers_id','=','customers.customers_id')
            ->join('payment_methods', 'orders.payment_methods_id','=','payment_methods.payment_methods_id')
            ->orderBy('orders_id','DESC')
            ->get();
        return response()->json($orders); 
    }

    public function AddOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customers_id' => 'required|integer',
            'payment_methods_id' => 'required|integer',
            'order_statuses_id' => 'required|integer',
            'order_date' => 'required|date',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.products_id' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            \Log::error('Validation Error', ['errors' => $validator->errors()]);
            return response()->json(['message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }
    
        try {
            // Begin transaction
            DB::beginTransaction();
    
            $order = new orderModel();
            $order->customers_id = $request->customers_id;
            $order->payment_methods_id = $request->payment_methods_id;
            $order->order_statuses_id = $request->order_statuses_id;
            $order->order_date = $request->order_date;
            $order->total = $request->total;
            $order->save();
    
            foreach ($request->items as $item) {
                $orderDetail = new orderDetailModel();
                $orderDetail->orders_id = $order->orders_id; // Use the correct primary key
                $orderDetail->products_id = $item['products_id'];
                $orderDetail->quantity = $item['quantity'];
                $orderDetail->price = $item['price'];
                $orderDetail->save();
            }
    
            // Commit transaction
            DB::commit();
            return response()->json(['message' => 'Order placed successfully!'], 201);
        } catch (Exception $e) {
            // Rollback transaction
            DB::rollBack();
            \Log::error('Error placing order: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
    public function EditOrder(Request $request, $id)
    {
        $products_id = $request->input('products_id');
        $customers_id = $request->input('customers_id');
        $payment_methods_id = $request->input('payment_methods_id');
        $order_statuses_id = $request->input('order_statuses_id');
        $order_date = $request->input('order_date');
        $total = $request->input('total');

        $result = DB::table('orders')
            ->where('orders_id', $id)
            ->update([
                'products_id' => $products_id,
                'customers_id' => $customers_id,
                'payment_methods_id' => $payment_methods_id,
                'order_statuses_id' => $order_statuses_id,
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