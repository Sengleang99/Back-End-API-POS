<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\customerModel;

class customerControllerapi extends Controller
{
    // Retrieve all customers
    public function ReadCustomer()
    {
        return customerModel::all();
    }

    // Retrieve customers using DB facade (if necessary for complex queries)
    public function GetCustomer()
    {
        return DB::table('Customers')->get();
    }

    // Add a new customer
    public function AddCustomer(Request $rq)
    {
        $data = $rq->only(['name', 'email', 'phone']);

        $result = DB::table('Customers')->insert($data);

        return $result 
            ? response()->json(['message' => 'Success!'], 201) 
            : response()->json(['message' => 'Fail!'], 500);
    }

    // Update a customer
    public function EditCustomer(Request $rq, $id)
    {
        $data = $rq->only(['name','email', 'phone']);

        $result = DB::table('Customers')
            ->where('customers_id', $id)
            ->update($data);

        return $result 
            ? response()->json(['message' => 'Success!']) 
            : response()->json(['message' => 'Fail!'], 500);
    }

    // Delete a customer
    public function DeleteCustomer($id)
    {
        $result = DB::table('Customers')
            ->where('customers_id', $id)
            ->delete();
        return $result 
            ? response()->json(['message' => 'Delete success!']) 
            : response()->json(['message' => 'Not found by id'], 404);
    }
}