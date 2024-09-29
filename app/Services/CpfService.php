<?php

namespace App\Services;

use Illuminate\Support\Str;


/**
 * Class CpfService
 *
 * Service for managing CPF.
 *
 * @author Alberto Aguiar Neto
 * @since 09/2024
 * 
 */
class CpfService
{
    
    /**
     * Process cpf (remove specials char)
     */
    public function processCpf(string $cpf)
    {
        $cpfNumbersOnly = preg_replace('/\D/', '', $cpf);

        if (!$this->__isValidCpf($cpfNumbersOnly)) {
            throw new \InvalidArgumentException('Invalid CPF provided.');
        }

        $cpfHash = hash('sha256', $cpfNumbersOnly);
        $cpfPrefix = Str::substr($cpfNumbersOnly, 0, 3);

        return [
            'cpf_prefix' => $cpfPrefix,
            'cpf_hash' => $cpfHash,
        ];
    }

    /**
     * Check if CPF is valid
     */
    private function __isValidCpf(string $cpf)
    {
        if (strlen($cpf) !== 11 || !is_numeric($cpf)) {
            return false;
        }

        $sum1 = 0;
        $sum2 = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum1 += $cpf[$i] * (10 - $i);
        }
        $firstVerifier = $sum1 % 11 < 2 ? 0 : 11 - ($sum1 % 11);

        if ($firstVerifier != $cpf[9]) {
            return false;
        }

        for ($i = 0; $i < 10; $i++) {
            $sum2 += $cpf[$i] * (11 - $i);
        }
        $secondVerifier = $sum2 % 11 < 2 ? 0 : 11 - ($sum2 % 11);

        return $secondVerifier == $cpf[10];
    }
}
