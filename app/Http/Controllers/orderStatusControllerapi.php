<?php

namespace App\Http\Controllers;
use App\Models\orderStatusModel;
use Illuminate\Http\Request;

class orderStatusControllerapi extends Controller
{
    public function Getorderstatus()
    {
        return orderStatusModel::all();
    }
}