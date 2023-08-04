<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CustomerPage(Request $request){

       return View('pages.Dashboard.customer');


    }

    public function CustomerList(Request $request){

        return Customer::where('user_id','=',$request->header('id'))->get();

        
    }

    public function CustomerCreate(Request $request){

        return Customer::create([

            'user_id'=>$request->header('id'),
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),

        ]);

        
    }

    public function CustomerDelete(Request $request){
        sleep(5);
        return Customer::where('user_id',$request->header('id'))
        ->where('id',$request->input('id'))->delete();

        
    }
    public function CustomerUpdate(Request $request){

        return Customer::where('user_id',$request->header('id'))
        ->where('id',$request->input('id'))->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
        ]);

        
    }
   
    public function CustomerById(Request $request){
         
        return Customer::where('user_id',$request->header('id'))
        ->where('id',$request->input('id'))->first(); 
        
    }

}

