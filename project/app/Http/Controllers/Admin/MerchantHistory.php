<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MerchantHistori;
use App\Models\Order;
use App\Models\Product;
use App\Models\Admin;
use App\helpers\SMS;
use DB;
use App\Models\Withdraw;
class MerchantHistory extends Controller
{
    

	public function __construct()
	{
	    $this->middleware('auth:admin');
	}

     public function calculate($id){

     	

         $order = Order::findOrFail($id);
         $cart = unserialize($order->cart);

         foreach ($cart->items  as $product) {

           $merchantHistory=new MerchantHistori();
         	  $merchnatname    =Product::findOrFail($product['item']['id'])->pro_owner;
            $price           =Product::findOrFail($product['item']['id'])->price;
            $product_nmber   =Product::findOrFail($product['item']['id'])->proid;
          	$admin           =Admin::where('username',$merchnatname)->first();
            $quantity        =$product['qty'];
            $fixcom          =$admin->commission;
            $totalcom        =round(($price*$fixcom)/100)*$quantity;

         	  $merchantHistory->merchant_id=$admin->id;
         	  $merchantHistory->pro_id     =$product['item']['id'];
           	$merchantHistory->order_id   =$order->id;
            $merchantHistory->commission =$totalcom;

               $message="Hello ".$admin->name.", we have deducted ".$fixcom."% commission from the order number ".$order->order_number." and product number ".$product_nmber.".Thank you for staying wth us.";
               SMS::sendSms(urlencode($message),$admin->phone);

                $merchantHistory->save();
         }

          $order->com_status=1;
          $order->save();
          
          $notification=array(
             'rmessage'=>'Commission calculated successfully',
             'alert-type'=>'success'
          );

          return redirect(route('admin-order-index'))->with($notification);

    }

    public function sell_history()
    {
        $sell_histories=MerchantHistori::all();
        return view('admin.merchant.sellhistory',compact('sell_histories'));
    }

    public function total_commission(){

             $commissions= DB::table('merchant_historis')
              ->join('admins', 'merchant_historis.merchant_id', '=', 'admins.id')
               ->select('merchant_historis.*', 'admins.*')
              ->select(DB::raw('merchant_id'), DB::raw('sum(merchant_historis.commission) as total'))
              ->groupBy(DB::raw('merchant_id') )
              ->get();
           
            return view('admin.merchant.commission',compact('commissions'));
    }

    public function allWithdraw(){
        $withdraws=Withdraw::where('type','=','merchant')->orderBy('id','DESC')->get();

       return view('admin.merchant.withdraw',compact('withdraws'));
    }

   

    
}
