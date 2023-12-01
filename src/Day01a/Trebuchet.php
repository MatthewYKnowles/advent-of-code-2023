<?php
declare(strict_types=1);

namespace Day01a;

class Trebuchet
{
    public function determineCalibrationValue(string $calibrationDocument): int
    {
        $total = 0;
        $lines = explode("\n", $calibrationDocument);
        foreach ($lines as $line) {
            $onlyDigits = preg_replace('~\D~', '', $line);
            $digitsLength = strlen($onlyDigits);
            if ($digitsLength > 2) {
                $firstDigit = $onlyDigits[0];
                $lastDigit = $onlyDigits[$digitsLength-1];
                $total += $firstDigit*10 + $lastDigit;
            }
            elseif ($digitsLength === 2) {
                $total += (int) $onlyDigits;
            } else {
                $singleDigit = (int) $onlyDigits;
                $total += $singleDigit*10 + $singleDigit;
            }
        }
        return $total;
    }
}