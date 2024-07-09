<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userControllerapi extends Controller
{
    // Retrieve all users
    public function ReadData()
    {
        return User::all();
    }

    // Retrieve users using DB facade (if necessary for complex queries)
    public function getUser()
    {
        return DB::table('users')->get();
    }

    // Add a new user
    public function userAdd(Request $rq)
    {
        $data = $rq->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']); // Hash the password

        $result = DB::table('users')->insert($data);

        return $result 
            ? response()->json(['message' => 'User created successfully!'], 201) 
            : response()->json(['message' => 'User creation failed!'], 500);
    }

    // Update a user
    public function editUser(Request $rq, $id)
    {
        $data = $rq->only(['name', 'email']);
        
        if ($rq->filled('password')) {
            $data['password'] = Hash::make($rq->input('password')); // Hash the password
        }

        $affected = DB::table('users')
            ->where('id', $id)
            ->update($data);

        return $affected 
            ? response()->json(['message' => 'User updated successfully!']) 
            : response()->json(['message' => 'User update failed!'], 500);
    }

    // Delete a user
    public function deleteUser($id)
    {
        $result = DB::table('users')
            ->where('id', $id)
            ->delete();

        return $result 
            ? response()->json(['message' => 'User deleted successfully!']) 
            : response()->json(['message' => 'User not found!'], 404);
    }
}