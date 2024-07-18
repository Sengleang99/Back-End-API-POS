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
            ->select('order.*','customers.name', 'payment_methods.method_name','order_statuses.status')
            ->join('customers', 'order.customers_id','=','customers.customers_id')
            ->join('order_statuses', 'order.order_statuses_id', '=', 'order_statuses.order_statuses_id')
            ->join('payment_methods', 'order.payment_methods_id','=','payment_methods.payment_methods_id')
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
    
            // Check stock quantity for each item
            foreach ($request->items as $item) {
                $product = DB::table('products')->where('products_id', $item['products_id'])->first();
                if (!$product || $product->stock_quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json(['message' => 'Insufficient stock for product ID: ' . $item['products_id']], 400);
                }
            }
    
            // Insert order
            $orderId = DB::table('order')->insertGetId([
                'customers_id' => $request->customers_id,
                'payment_methods_id' => $request->payment_methods_id,
                'order_statuses_id' => $request->order_statuses_id,
                'order_date' => $request->order_date,
                'total' => $request->total,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            // Insert order details and decrement stock quantity
            foreach ($request->items as $item) {
                DB::table('order_detail')->insert([
                    'orders_id' => $orderId,
                    'products_id' => $item['products_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
    
                // Decrement stock quantity
                DB::table('products')
                    ->where('products_id', $item['products_id'])
                    ->decrement('stock_quantity', $item['quantity']);
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