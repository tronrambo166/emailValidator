<?php
use Akaunting\Money\Money;
function formatCurrency($amount, $isoCode)
{
    if (!$amount) {
        return $amount;
    }
    $decimalPoint = currency($isoCode)->getDecimalMark();

    if ($decimalPoint == ",") {
        $amount = str_replace(".", ",", $amount);
    }

    return Money::$isoCode($amount, true)->format();
}
function getWorkspaceCurrency($settings)
{
    return $settings['currency'] ?? config('app.currency');
}
