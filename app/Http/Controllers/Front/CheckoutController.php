<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;

use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0)
        {
            return redirect()->route('home');
        }
        $countries = Countries::getNames();
        return view('front.checkout',compact('cart','countries'));
    }

    public function store(Request $request,CartRepository $cart)
    {
        //Database Transaction
        DB::beginTransaction();
        try {
            $request->validate([
                'address.billing.first_name' => ['required','string','max:255'],
                'address.billing.last_name' => ['required','string','max:255'],
                'address.billing.phone_number' => ['required','string','max:255'],
                'address.billing.city' => ['required','string','max:255'],
            ]);
            $items = $cart->get()->groupBy('product.store_id')->all();
            foreach ($items as $store_id =>$cart_items)
            {

                $order = Order::create([
                    'store_id'=>$store_id,
                    'user_id'=>Auth::id(),
                    'payment_method'=>'cod'
                ]);
                foreach ($cart_items as $item)
                {
                    OrderItem::create([
                        'order_id'=>$order->id,
                        'product_id'=>$item->product->id,
                        'product_name'=>$item->product->name,
                        'price'=>$item->product->price,
                        'quantity'=>$item->quantity,
                    ]);
                }
                foreach ($request->post('address') as $type => $address)
                {

                    $address['type'] = $type;
//                    $address['order_id']=$order->id;
//                    $order_address = OrderAddress::create($address);
                    $order->addresses()->create($address);
                }

            }
            DB::commit();
//            event('order.created',$order,Auth::user());
            event(new OrderCreated($order));


        }catch (\Throwable $e)
        {
            DB::rollBack();
            throw $e;
        }
        return redirect()->route('orders.payments.create',$order->id);



    }
}
