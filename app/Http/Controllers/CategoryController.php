<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function CategoryPage(Request $request){

       return View('pages.Dashboard.category-page');

    }
    
    public function CategoryList(Request $request){

        return Category::where('user_id',$request->header('id'))->get();

    }
    public function CategoryCreate(Request $request){
        sleep(5);
       return Category::create([

          'name'=>$request->input('name'),
          'user_id'=>$request->header('id')
       ]);

    }
    public function CategoryUpdate(Request $request){
              
        return Category::where('id',$request->input('id'))->where('user_id',$request->header('id'))->update([
            'name'=>$request->input('name'),
        ]);


    }
    public function CategoryDelete(Request $request){
       // sleep(5);

        return Category::where('id',$request->input('id'))->where('user_id',$request->header('id'))->delete([
            'name'=>$request->input('name'),
        ]);

     

    }
    public function CategoryByID(Request $request){

        $category_id=$request->input('id');
        $user_id=$request->header('id');
        return Category::where('id',$category_id)->where('user_id',$user_id)->first();

    }
}
