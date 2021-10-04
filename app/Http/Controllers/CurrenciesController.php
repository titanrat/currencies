<?php

namespace App\Http\Controllers;

use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Gerardojbaez\Money\Exceptions\CurrencyException;
use Gerardojbaez\Money\Money;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    private ExchangeRate $api;


    private ?array $supportedCurrencies;

    public function __construct()
    {
        $this->api = new ExchangeRate();
        $this->supportedCurrencies = $this->api->shouldCache(true)->currencies();
    }

    public function index()
    {
        return view('index', [
            'supportedCurrencies' => $this->supportedCurrencies
        ]);
    }

    public function convert(Request $request)
    {
        $request->merge([
            'supportedCurrencies' => $this->supportedCurrencies
        ]);
        $validated = $request->validate([
            'baseCurrency' => 'required|in_array:supportedCurrencies.*',
            'targetCurrency' => 'required|different:baseCurrency|in_array:supportedCurrencies.*',
            'value' => 'required|numeric|gt:0'
        ]);
        $converted = $this->api->convert($validated['value'], $validated['baseCurrency'], $validated['targetCurrency']);
        try {
            $result = (new Money($converted, $validated['targetCurrency']))->format();
            //Not the best way but exotic currencies was too exotic for any library or solution that I found
        } catch (CurrencyException $e) {
            $result = $converted . ' ' . $validated['targetCurrency'];
        }
        return response()->json(
            [
                'converted' => $result,
            ]
        );
    }
}
