<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\paymentModel;

class paymentControllerapi extends Controller
{
    public function Readpayment()
    {
        return paymentModel::all();
    }

    public function Getpayment()
    {
        return DB::table('payment_methods')->get();
    }

    public function Addpayment(Request $rq)
    {
        $method_name = $rq->input('method_name');

        $result = DB::table('payment_methods')->insert([
            'method_name' => $method_name
        ]);

        return $result 
            ? response()->json(['message' => 'Success!'], 201) 
            : response()->json(['message' => 'Fail!'], 500);
    }

    public function Editpayment(Request $rq, $id)
    {
        $method_name = $rq->input('method_name');

        $result = DB::table('payment_methods')
            ->where('payment_methods_id', $id)
            ->update([
                'method_name' => $method_name
            ]);

        return $result 
            ? response()->json(['message' => 'Success!']) 
            : response()->json(['message' => 'Fail!'], 500);
    }

    public function Deletepayment($id)
    {
        $result = DB::table('payment_methods')
            ->where('payment_methods_id', $id)
            ->delete();

        return $result 
            ? response()->json(['message' => 'Delete success!']) 
            : response()->json(['message' => 'Not found by id'], 404);
    }
}