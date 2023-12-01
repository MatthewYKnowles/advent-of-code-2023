<?php
declare(strict_types=1);

namespace Day01a;

class Trebuchet
{
    public function determineCalibrationValue(string $calibrationDocument): int
    {
        $lines = explode("\n", $calibrationDocument);
        return array_reduce($lines, fn(int $total, string $line) => $total + $this->calculateLineTotal($line), 0);
    }

    public function determineCalibrationValueWithEnglishNumbers(string $calibrationDocument): int
    {
        $calibrationDocumentTranslatesOnes = str_replace('one', 'one1one', $calibrationDocument);
        $calibrationDocumentTranslatesTwos = str_replace('two', 'two2two', $calibrationDocumentTranslatesOnes);
        $calibrationDocumentTranslatesThrees = str_replace('three', 'three3three', $calibrationDocumentTranslatesTwos);
        $calibrationDocumentTranslatesFours = str_replace('four', 'four4four', $calibrationDocumentTranslatesThrees);
        $calibrationDocumentTranslatesFives = str_replace('five', 'five5five', $calibrationDocumentTranslatesFours);
        $calibrationDocumentTranslatesSixes = str_replace('six', 'six6six', $calibrationDocumentTranslatesFives);
        $calibrationDocumentTranslatesSevens = str_replace('seven', 'seven7seven', $calibrationDocumentTranslatesSixes);
        $calibrationDocumentTranslatesEights = str_replace('eight', 'eight8eight', $calibrationDocumentTranslatesSevens);
        $calibrationDocumentTranslatesNines = str_replace('nine', 'nine9nine', $calibrationDocumentTranslatesEights);
        return $this->determineCalibrationValue($calibrationDocumentTranslatesNines);
    }

    public function calculateLineTotal(string $line): int
    {
        $onlyDigits = preg_replace('~\D~', '', $line);
        $firstDigitInTheTensPlace = $onlyDigits[0] * 10;
        $lastDigit = $onlyDigits[strlen($onlyDigits) - 1];
        return $firstDigitInTheTensPlace + $lastDigit;
    }
}