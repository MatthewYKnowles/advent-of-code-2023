<?php
declare(strict_types=1);

namespace Day03;

class EngineSchematics
{
    public function determineSumOfPartNumbers(string $engineSchematics): int
    {
        $games = explode("\n", $engineSchematics);
        $validNumbers = [];
        for ($x = 0; $x < count($games); $x++) {
            $lineCharacters = str_split($games[$x]);
            $maybeValidNumber = '';
            for ($y = 0; $y < count($lineCharacters); $y++) {
                $character = $lineCharacters[$y];
                if ($this->characterIsADigit($character)) {
                    $maybeValidNumber .= $character;
                }
                if (!$this->characterIsADigit($character)) {
                    $indexBeforeNumberStart = $y - strlen($maybeValidNumber) - 1;
                    $hasSymbolNeighbor = $this->isSpecialChacter($character);
                    if ($indexBeforeNumberStart >= 0) {
                        $previousCharacter = $lineCharacters[$indexBeforeNumberStart];
                        if ($this->isSpecialChacter($previousCharacter)) {
                            $hasSymbolNeighbor = true;
                        }
                    }
                    if ($x + 1 < count($games)) {
                        $nextGame = $games[$x+1];
                        if ($this->isSpecialChacter($nextGame[$y])){
                            $hasSymbolNeighbor = true;
                        }
                        $indexBeforeNumberStart = $y - strlen($maybeValidNumber);
                        if ($indexBeforeNumberStart >= 0){
                            if ($this->isSpecialChacter($nextGame[$indexBeforeNumberStart])){
                                $hasSymbolNeighbor = true;
                            }
                        }
                    }
                    if ($hasSymbolNeighbor) {
                        $validNumbers[] = (int) $maybeValidNumber;
                    }
                    $maybeValidNumber = '';
                }
                if ($y + 1 === count($lineCharacters)) {
                    $indexBeforeNumberStart = $y - strlen($maybeValidNumber);
                    $hasSymbolNeighbor = $this->isSpecialChacter($character);
                    if ($indexBeforeNumberStart >= 0) {
                        $previousCharacter = $lineCharacters[$indexBeforeNumberStart];
                        if ($this->isSpecialChacter($previousCharacter)) {
                            $hasSymbolNeighbor = true;
                        }
                    }
                    if ($x + 1 < count($games)) {
                        $nextGame = $games[$x+1];
                        if ($this->isSpecialChacter($nextGame[$y])){
                            $hasSymbolNeighbor = true;
                        }
                        if ($indexBeforeNumberStart >= 0){
                            if ($this->isSpecialChacter($nextGame[$indexBeforeNumberStart])){
                                $hasSymbolNeighbor = true;
                            }
                        }
                    }
                    if ($hasSymbolNeighbor) {
                        $validNumbers[] = (int) $maybeValidNumber;
                    }
                    $maybeValidNumber = '';
                }
            }
        }
        return array_sum($validNumbers);
    }

    public function characterIsADigit(mixed $character): int|false
    {
        return preg_match('/\d/', $character);
    }

    public function isSpecialChacter(mixed $character): bool
    {
        return $character !== '.' && !$this->characterIsADigit($character);
    }
}