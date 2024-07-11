<?php

namespace App\Helpers\V1;

use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class CurrencyHelper
{
    public static function format_currency_us_local($value, $currency_code = null)
    {
        if (is_null($currency_code)) {
            $currency_code = 'usd';
        }
        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($value, $currency_code);
    }
}
