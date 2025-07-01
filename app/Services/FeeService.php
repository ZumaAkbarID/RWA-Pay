<?php

namespace App\Services;

class FeeService
{
  public static function calculateFee(float $amount, float $flat, float $percent): float
  {
    $percentAmount = ($amount * $percent) / 100;
    return round($flat + $percentAmount, 2);
  }
}