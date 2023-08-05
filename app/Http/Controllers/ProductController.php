<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    function ProductPage(Request $request){
        return View('pages.Dashboard.product-page');

    }
    function CreateProduct(Request $request){
        $user_id = $request->header('id');
        $image = $request->file('img');
        $file_name = $image->getClientOriginalName();
        $t=time();
        $image_name = "$user_id-$t-$file_name";
        $img_url = "/uploads/product-image/$image_name";


        //upload image in public uploads/product-image folder

        $image->move(public_path('uploads/product-image'),$image_name);
        //save to db
        return Product::create([

            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id

        ]);


    }
    function DeleteProduct(Request $request){


        $user_id=$request->header('id');
        $product_id=$request->input('id');
        $filePath=$request->input('file_path');
        File::delete($filePath);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();



    }
    function UpdateProduct(Request $request){

        $user_id = $request->header('id');
        $product_id = $request->input('id');

        if($request->hasFile('img')){



        $user_id = $request->header('id');
        $image = $request->file('img');
        $file_name = $image->getClientOriginalName();
        $t=time();
        $image_name = "$user_id-$t-$file_name";
        $img_url = "/uploads/product-image/$image_name";

        //Delete Old file
           
        $filepath = $request->input('file_path');
        File::delete($filepath);


         //update to db
         return Product::where('user_id',$user_id)->where('id',$product_id)->update([

            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
            'category_id'=>$request->input('category_id'),
            'user_id'=>$user_id

        ]);


}


        else{
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id'),
            ]);
        }



    }
    function ProductList(Request $request){

        $user_id=$request->header('id');
        return Product::where('user_id',$user_id)->get();

    }
    function ProductByID(Request $request){

        $user_id=$request->header('id');
        $product_id=$request->input('id');
        return Product::where('id',$product_id)->where('user_id',$user_id)->first();

    }
    
}
