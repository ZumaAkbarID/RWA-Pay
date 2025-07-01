<?php

namespace App\Services;

/**
 * Service untuk membuat QRIS Dinamis dari QRIS Statis.
 * 
 * Reference : https://github.com/verssache/qris-dinamis
 */

class QRISService
{
  /**
   * Generate QRIS Dinamis dari QRIS Statis + nominal + biaya layanan (opsional)
   * Biaya layanan udah gak working
   */
  public function generateDynamic(int|string $amount, ?string $qrisStatic = null, ?array $fee = null): string
  {
    $qrisStatic ??= config('qris.static');
    if (!$qrisStatic) {
      throw new \Exception('QRIS statis config tidak tersedia.');
    }

    $qrisStatic = substr($qrisStatic, 0, -4); // hapus CRC statis
    $qrisStatic = str_replace('010211', '010212', $qrisStatic); // ubah ke dinamis

    $parts = explode('5802ID', $qrisStatic);
    if (count($parts) !== 2) {
      throw new \InvalidArgumentException('QRIS tidak valid: gagal parsing pada 5802ID');
    }

    $payload = '54' . sprintf('%02d', strlen($amount)) . $amount;

    if ($fee) {
      $feeValue = $fee['value'];
      if ($fee['type'] === 'r') {
        $payload .= '55020256' . sprintf('%02d', strlen($feeValue)) . $feeValue;
      } elseif ($fee['type'] === 'p') {
        $payload .= '55020357' . sprintf('%02d', strlen($feeValue)) . $feeValue;
      }
    }

    $payload .= '5802ID';

    $data = trim($parts[0]) . $payload . trim($parts[1]);
    return $data . $this->calculateCRC16($data);
  }

  /**
   * Kalkulasi CRC16 checksum (EMV standard)
   */
  public function calculateCRC16(string $input): string
  {
    $crc = 0xFFFF;
    $len = strlen($input);

    for ($c = 0; $c < $len; $c++) {
      $crc ^= ord($input[$c]) << 8;

      for ($i = 0; $i < 8; $i++) {
        if ($crc & 0x8000) {
          $crc = ($crc << 1) ^ 0x1021;
        } else {
          $crc <<= 1;
        }
        $crc &= 0xFFFF; // pastikan tetap 16-bit
      }
    }

    return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
  }
}