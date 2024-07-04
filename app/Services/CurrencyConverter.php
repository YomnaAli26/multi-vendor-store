<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    public $baseUrl = "https://api.currencyapi.com/v3";

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from,string $to,float $amount = 1)
    {
        $currencies = $from.','.$to;
        $response = Http::baseUrl($this->baseUrl)
            ->get('/latest',[
                'apikey'=>$this->apiKey,
              'currencies'=>$currencies,
            ]);
        $result = $response->json();
        return $result['data'][$to]['value']*$amount;
    }
}
