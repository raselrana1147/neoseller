<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use Datatables;
use Illuminate\Http\Request;
use App\helpers\SMS;
use DB;
use App\Models\User;
use App\Transaction;
use App\Models\Account;
Use App\Models\Product;
use App\Models\Admin;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('superadmin');
    }

    //*** JSON Request
    public function datatables($status)
    {


        if($status == 'pending'){
            $datas = Order::where('status','=','pending')->get();
        }
        elseif($status == 'processing') {
            $datas = Order::where('status','=','processing')->get();
        }
        elseif($status == 'completed') {
            $datas = Order::where('status','=','completed')->get();
        }
        elseif($status == 'declined') {
            $datas = Order::where('status','=','declined')->get();
        }elseif ($status =='on delivery') {
          $datas = Order::where('status','=','on delivery')->get();
        }
        else{
          $datas = Order::orderBy('id','desc')->get();  
        }
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                           
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                return '<div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>

                                 <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i>Track Order</a>'.$orders.'</div>';
                            }) 
                            ->addColumn('Calculate', function(Order $data) {
                                   return $data['com_status'] == 0 ? '<div class="action-list"><a href="' . route('admin-order-commission',$data->id) . '"> <i class="fas fa-dollar-sign"></i> Get Commission</a>': '<div class="action-list"><a href="#">Completed</a></div>';
                            }) 
                            ->rawColumns(['id','action','Calculate'])
                            ->toJson(); 
                            
    }


    public function index()
    {
        return view('admin.order.index');
    }

    public function showDetails($id){
         $order = Order::findOrFail($id);
         $cart = unserialize($order->cart);
         //$cart = unserialize(bzdecompress(utf8_decode($order->cart)));
         return view('admin.order.commissionDetails',compact('order','cart'));
    }

   

    public function edit($id)
    {

        $data = Order::find($id);
        return view('admin.order.delivery',compact('data'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {

        
        //--- Logic Section
                 $data = Order::findOrFail($id);
                 $data->status=$request->status;

                 $data->payment_status=$request->payment_status;
                 $data->order_note=$request->track_text;

                 $orderId=$data->order_number;
               
                 switch ($request->status) {
                     case 'pending':

                     $message="Congratulations! You have successfully placed your order from neoseller.com.bd Your order id is".$orderId.". Soon we'll contact for confirming your order.";
                         break;

                         case 'processing':
                            $message="Dear customer, your order ".$orderId." has been confirmed. Thanks for shopping with neoseller.com.bd";
                             break;

                        case 'on delivery':
                         $message="Dear customer, your order ".$orderId." is sending through Sundarban courier service. Your tracking ID. Please follow the link for tracking your product lacation. Thank you.";
                        break;

                        case 'completed':
                           $message="Dear customer, your order ".$orderId." has delivered successfully. Thank you for choosing neoseller.com.bd";


                            $user=User::where('id',$data->user_id)->first();
                            $user->incomebalance +=$data->affilate_charge;
                            $user->save();
                            $data->affilate_charge=0;
                            $data->save();

                          $cart=unserialize($data->cart);
                          foreach ($cart->items as $product) {
                              $account=new Account;

                              $pro=Product::find($product['item']['id']);
                              $admin=Admin::where('username',$pro->pro_owner)->first();

                              $total_order_amount=$pro->price*$product['qty'];

                              $cut_commission=(($total_order_amount*$admin->commission)/100);
                              $total_amount=$total_order_amount-$cut_commission;

                            
                              $account->order_id      =$data->id;
                              $account->pro_id        =$pro->id;
                              $account->merchant_user =$admin->id;
                              $account->amount        =$total_amount;
                              $account->commission    =$cut_commission;
                              $account->save();

                          }


                            break;
                        case 'declined':
                            $message="Order".$orderId." has been cancled by customer. nneoseller.com.bd";
                            break;
                     default:
                         break;
                 }

                 $data->save();

                 $to=$data->customer_phone;
                 $get=SMS::sendSms(urlencode($message),$to);
                 if ($get) {
                     $msg = 'Status Updated Successfully.';
                     return response()->json($msg);
                 }else{
                     return back();
                 }
    }



    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }

    public function deliver()
    {
        return view('admin.order.deliver');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function declined()
    {
        return view('admin.order.declined');
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
       // $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart = unserialize($order->cart);
        return view('admin.order.details',compact('order','cart'));
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize($order->cart);

        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);                
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {   
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }

    public function status($id,$status)
    {
        $mainorder = Order::findOrFail($id);

    }
}