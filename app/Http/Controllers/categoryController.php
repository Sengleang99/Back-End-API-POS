<?php

namespace App\Http\Controllers;

use App\Models\categoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
    public function ReadCategory()
    {
        return categoryModel::all();
    }

    public function GetCategory(Request $rq)
    {
        return DB::table('categories')->get();
    }

    public function AddCategory(Request $rq)
    {
        $categories_name = $rq->input('categories_name');
        $description = $rq->input('description');

        $result = DB::table('categories')->insert([
            'categories_name' => $categories_name,
            'description' => $description
        ]);
        return $result ? response()
        ->json(['message' => 'Success!'], 201) : response()->json(['message' => 'Fail!'], 500);
    }

    public function EditCategory(Request $rq, $id)
    {
        $categories_name = $rq->input('categories_name');
        $description = $rq->input('description');

        $result = DB::table('categories')
            ->where('categories_id', $id)
            ->update([
                'categories_name' => $categories_name,
                'description' => $description
            ]);

        return $result ? response()->json(['message' => 'Success!']) : response()->json(['message' => 'Fail!'], 500);
    }

    public function DeleteCategory($id)
    {
        $result = DB::table('categories')->where('categories_id', $id)->delete();
        return $result ? response()
        ->json(['message' => 'Delete success!']) : response()
        ->json(['message' => 'Not found by id'], 404);
    }
}