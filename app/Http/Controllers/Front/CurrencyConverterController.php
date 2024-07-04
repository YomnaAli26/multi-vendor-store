<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
           'currency_code'=>['required','string','size:3'],
        ]);
        $base_currency_code = config('app.currency');
        $currencyCode = $request->post('currency_code');
        $cacheKey= 'currency_rate_'.$currencyCode;
        $rate = Cache::get($cacheKey,0);

        if (!$rate)
        {
            $converter = app('currency.converter');
            $rate = $converter->convert($base_currency_code,$currencyCode);
            Cache::put($cacheKey,$rate,now()->addMinutes(60));
        }
        Session::put('currency_code',$currencyCode);
        return redirect()->back();

    }
}
