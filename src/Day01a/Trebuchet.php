<?php
declare(strict_types=1);

namespace Day01a;

class Trebuchet
{
    public function determineCalibrationValueWithEnglishNumbers(string $calibrationDocument): int
    {
        $calibrationDocumentTranslatesOnes = $this->replaceEnglishNumbersWithArabicNumbers($calibrationDocument);
        return $this->determineCalibrationValue($calibrationDocumentTranslatesOnes);
    }

    public function determineCalibrationValue(string $calibrationDocument): int
    {
        $lines = explode("\n", $calibrationDocument);
        return array_reduce($lines, fn(int $total, string $line) => $total + $this->calculateLineTotal($line), 0);
    }

    public function calculateLineTotal(string $line): int
    {
        $onlyDigits = preg_replace('~\D~', '', $line);
        $firstDigitInTheTensPlace = $onlyDigits[0] * 10;
        $lastDigit = $onlyDigits[strlen($onlyDigits) - 1];
        return $firstDigitInTheTensPlace + $lastDigit;
    }

    public function replaceEnglishNumbersWithArabicNumbers(string $calibrationDocument): string|array|null
    {
        return preg_replace(['/one/', '/two/', '/three/', '/four/', '/five/', '/six/', '/seven/', '/eight/', '/nine/'],
            ['one1one', 'two2two', 'three3three', 'four4four', 'five5five', 'six6six', 'seven7seven', 'eight8eight', 'nine9nine'],
            $calibrationDocument);
    }
}