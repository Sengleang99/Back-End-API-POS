<?php

namespace App\Http\Controllers;
use App\Models\imageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class productImageControllerapi extends Controller
{
    public function Readimage(){
        $Image = imageModel::all();
        echo $Image;
    }
    public function Getimage(Request $rq){
        $Image = DB::table('product_images')->get();
        echo $Image;
    }
    public function Addimage(Request $rq){
        $product_id = $rq->input('product_id');
        $image_url = $rq->input('image_url');
        $result = DB::table('product_images')
        ->insert([
            'product_id'=>$product_id,
            'image_url'=>$image_url
        ]);
        if(isset($result)){
            echo "Success!";
        }else{
            echo "Fail!";
        }
    }
    public function Editimage(Request $rq){
        $image_id = $rq->input('image_id');
        $product_id = $rq->input('product_id');
        $image_url = $rq->input('image_url');
            $Result = DB::table('product_images')
            ->where('image_id', $image_id)
            ->update([
                'product_id'=>$product_id,
                'image_url'=>$image_url
            ]);
            if(isset($Result)){
                echo "Success!";
            }else{
                echo "Fail!";
            }
    }
    public function Deleteimage(Request $rq){
        $image_id = $rq->input('image_id');
        $result = DB::table('product_images')->where('image_id', '=', $image_id)->delete();
        if(isset($result)){
            echo "delete success!";
        }else{
            echo "Not found by id";
        }
    }
}