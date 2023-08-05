<?php

namespace App\Http\Controllers;

use App\Mail\PromotionalMail;
use App\Models\Customer;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PromotionalMailController extends Controller
{
    function PromotionalMailPage(){

        return view('pages.promotion_mail.promotion-page');

    }

    function PromotionalContent(Request $request){

        $customers = Customer::where('user_id',$request->header('id'))->select('email')->get();
        

        try{

            foreach($customers as $customer){
                Mail::to($customer->email)->send(new PromotionalMail($request->sub,$request->content));
            }
            return response()->json( ['status' => 'success', 'message' => 'message send successfully'], 200 );

        }
        catch(Throwable $th){
            //echo $th;

            return response()->json( ['status' => 'failed', 'message' => 'message send failed'], 500 );

        }

        




    }
}
