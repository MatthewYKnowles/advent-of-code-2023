<?php
declare(strict_types=1);

namespace Day01a;

class Trebuchet
{
    public function determineCalibrationValue(string $calibrationDocument): int
    {
        $onlyDigits = preg_replace('~\D~', '', $calibrationDocument);
        $digitsLength = strlen($onlyDigits);
        if ($digitsLength > 2) {
            $firstDigit = $onlyDigits[0];
            $lastDigit = $onlyDigits[$digitsLength-1];
            return $firstDigit*10 + $lastDigit;
        }
        if ($digitsLength === 2) {
            return (int) $onlyDigits;
        }
        $singleDigit = (int) $onlyDigits;
        return $singleDigit*10 + $singleDigit;
    }
}