<?php
declare(strict_types=1);

namespace Day03;

class EngineSchematics
{
    public function determineSumOfPartNumbers(string $engineSchematics): int
    {
        $lineCharacters = str_split($engineSchematics);
        $validNumbers = [];
        $maybeValidNumber = '';
        for ($x = 0; $x < count($lineCharacters); $x++) {
            $character = $lineCharacters[$x];
            if ($this->characterIsADigit($character)) {
                $maybeValidNumber .= $character;
                if($x + 1 === count($lineCharacters)){
                    $validNumbers[] = (int) $maybeValidNumber;
                }
            }
            if (!$this->characterIsADigit($character)) {
                $hasSymbolNeighbor = $character !== '.';
                $indexBeforeNumberStart = $x - strlen($maybeValidNumber) - 1;
                if ($indexBeforeNumberStart >= 0) {
                    $previousCharacter = $lineCharacters[$indexBeforeNumberStart];
                    if ($previousCharacter !== '.') {
                        $hasSymbolNeighbor = true;
                    }
                }
                if ($hasSymbolNeighbor) {
                    $validNumbers[] = (int) $maybeValidNumber;
                }
                $maybeValidNumber = '';
            }
        }
        return array_sum($validNumbers);
    }

    public function characterIsADigit(mixed $character): int|false
    {
        return preg_match('/\d/', $character);
    }
}