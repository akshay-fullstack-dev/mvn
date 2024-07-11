<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class CurrencyHelper
{
    public static function format_currency_us_local($value, $currency_code = null)
    {
        // echo '--------' . $currency_code . '-------';
        if (is_null($currency_code))
            $currency_code = 'usd';
        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($value, $currency_code);
    }
}
