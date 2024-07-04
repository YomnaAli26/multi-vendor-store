<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =[
        'store_id','user_id','payment_method','status','payment_status'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'=>'Guest Customer'
        ]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'order_items')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name','price','quantity','options'
            ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->where('type','billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->where('type','shipping');

    }

    public function items()
    {
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
    public static function booted()
    {
        static::creating(function (Order $order){
            $order->number = static::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        //20230001
        $year = Carbon::now()->year;
        //SELECT MAX(number) FROM orders
        $number = Order::whereYear('created_at',$year)->max('number');
        if ($number)
        {
            return $number+1;
        }
        return $year.'0001';
    }
}
