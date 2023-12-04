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
                if (!$this->characterIsADigit($character) || $this->endOfLine($y, $lineCharacters)) {
                    $indexBeforeNumberStart = !$this->characterIsADigit($character)
                        ? $y - strlen($maybeValidNumber) - 1
                        : $y - strlen($maybeValidNumber);
                    $hasSymbolNeighbor = $this->isSpecialChacter($character);
                    if ($indexBeforeNumberStart >= 0) {
                        $previousCharacter = $lineCharacters[$indexBeforeNumberStart];
                        if ($this->isSpecialChacter($previousCharacter)) {
                            $hasSymbolNeighbor = true;
                        }
                    }
                    if ($x + 1 < count($games)) {
                        $nextGame = $games[$x+1];
                        $neighbors = [];
                        if ($indexBeforeNumberStart >= 0){
                            $neighbors[] = $nextGame[$indexBeforeNumberStart];
                        }
                        for ($h = 0; $h < strlen($maybeValidNumber); $h++) {
                            $neighbors[] = $nextGame[$indexBeforeNumberStart + $h + 1];
                        }
                        $gameStringLength = strlen($games[$x]);
                        $potentialIndex = $indexBeforeNumberStart + 1 + strlen($maybeValidNumber);
                        if ($potentialIndex < $gameStringLength){
                            $neighbors[] = $nextGame[$potentialIndex];
                        }
                        $hasSymbol = array_reduce($neighbors, fn (bool $hasSymbol, string $char) => $hasSymbol ||
                        $this->isSpecialChacter($char), false);
                        if ($hasSymbol) {
                            $hasSymbolNeighbor = true;
                        }
                    }
                    if ($x - 1 >= 0) {
                        $previousGame = $games[$x-1];
                        $neighbors = [];
                        if ($indexBeforeNumberStart >= 0){
                            $neighbors[] = $previousGame[$indexBeforeNumberStart];
                        }
                        for ($h = 0; $h < strlen($maybeValidNumber); $h++) {
                            $neighbors[] = $previousGame[$indexBeforeNumberStart + $h + 1];
                        }
                        $gameStringLength = strlen($games[$x]);
                        $potentialIndex = $indexBeforeNumberStart + 1 + strlen($maybeValidNumber);
                        if ($potentialIndex < $gameStringLength){
                            $neighbors[] = $previousGame[$potentialIndex];
                        }
                        $hasSymbol = array_reduce($neighbors, fn (bool $hasSymbol, string $char) => $hasSymbol ||
                            $this->isSpecialChacter($char), false);
                        if ($hasSymbol) {
                            $hasSymbolNeighbor = true;
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

    public function endOfLine(int $y, array $lineCharacters): bool
    {
        return $y + 1 === count($lineCharacters);
    }
}