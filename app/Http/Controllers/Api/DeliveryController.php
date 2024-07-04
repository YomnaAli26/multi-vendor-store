<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdated;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function show($id)
    {
        $delivery = Delivery::query()->select([
            'order_id',
            'status',
            DB::raw("ST_X(current_location) AS lang"),
            DB::raw("ST_Y(current_location) AS lat")
        ])->where('id',$id)->firstOrFail();
        return $delivery;

    }

    public function update(Request $request,Delivery $delivery)
    {
        $request->validate([
           'lng'=>['required','numeric'],
            'lat'=>['required','numeric'],
        ]);
        $delivery->update([
            'current_location'=>DB::raw("POINT({$request->lat},{$request->lng})")
        ]);
        event(new DeliveryLocationUpdated($request->lat,$request->lng));
        return $delivery;
    }
}
