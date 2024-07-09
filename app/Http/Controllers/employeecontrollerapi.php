<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\employeeModel;

class employeecontrollerapi extends Controller
{
    public function ReadEmployee()
    {
        $employees = employeeModel::all();
        return response()->json($employees);
    }

    public function GetEmployee(Request $rq)
    {
        $employees = DB::table('employees')->get();
        return response()->json($employees);
    }

    public function AddEmployee(Request $rq)
    {
        $name = $rq->input('name');
        $position = $rq->input('position');
        $email = $rq->input('email');

        $result = DB::table('employees')->insert([
            'name' => $name,
            'position' => $position,
            'email' => $email
        ]);

        return $result ? response()->json(['message' => 'Success!'], 201) : response()->json(['message' => 'Fail!'], 500);
    }
    public function EditEmployee(Request $rq, $id)
    {
        $name = $rq->input('name');
        $position = $rq->input('position');
        $email = $rq->input('email');

        $result = DB::table('employees')
            ->where('employees_id', $id)
            ->update([
                'name' => $name,
                'position' => $position,
                'email' => $email
            ]);

        return $result ? response()->json(['message' => 'Success!']) : response()->json(['message' => 'Fail!'], 500);
    }

    public function DeleteEmployee($id)
    {
        $result = DB::table('employees')->where('employees_id', $id)->delete();

        return $result ? response()->json(['message' => 'Delete success!']) : response()->json(['message' => 'Not found by id'], 404);
    }
}