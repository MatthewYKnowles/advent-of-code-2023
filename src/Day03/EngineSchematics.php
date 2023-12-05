<?php
declare(strict_types=1);

namespace Day03;

use function strlen;

class EngineSchematics
{
    public function determineSumOfPartNumbers(string $engineSchematics): int
    {
        $lines = explode("\n", $engineSchematics);
        $lineLength = strlen($lines[0]);
        $validNumbers = [];
        for ($x = 0; $x < count($lines); $x++) {
            $maybeValidNumber = '';
            for ($y = 0; $y < $lineLength; $y++) {
                $character = $lines[$x][$y];
                if ($this->characterIsADigit($character)) {
                    $maybeValidNumber .= $character;
                }
                if ($this->isSpecialCharacter($character)){
                    $validNumbers[] = (int) $maybeValidNumber;
                    $maybeValidNumber = '';
                }
                if (strlen($maybeValidNumber) > 0 && ($character === '.' || $this->endOfLine($y,
                            $lineLength))) {
                    $indexBeforeNumberStart = !$this->characterIsADigit($character)
                        ? $y - strlen($maybeValidNumber) - 1
                        : $y - strlen($maybeValidNumber);
                    $items = [$character];
                    if ($indexBeforeNumberStart >= 0) {
                        $items[] = $lines[$x][$indexBeforeNumberStart];
                    }
                    if ($x + 1 < count($lines)) {
                        $items = array_merge($items, $this->getSubOfCharactersInALine($lines[$x+1], $indexBeforeNumberStart, strlen($maybeValidNumber)));
                    }
                    if ($x - 1 >= 0) {
                        $items = array_merge($items, $this->getSubOfCharactersInALine($lines[$x-1], $indexBeforeNumberStart,
                            strlen($maybeValidNumber)));
                    }
                    $hasSymbol = array_reduce($items, fn (bool $hasSymbol, string $char) => $hasSymbol || $this->isSpecialCharacter($char), false);
                    if ($hasSymbol) {
                        $validNumbers[] = (int) $maybeValidNumber;
                    }
                    $maybeValidNumber = '';
                }
            }
        }
        return array_sum($validNumbers);
    }


    public function sumOfGearRatios(string $engineSchematics): int
    {
        $lines = explode("\n", $engineSchematics);
        $lineLength = strlen($lines[0]);
        $sumOfRatios = 0;
        for ($y = 0; $y < $lineLength; $y++) {
            $character = $lines[0][$y];
            if ($y > 0 && $character === '*') {
                $surroundingNumbers = [];
                $surroundingNumbers = array_merge($surroundingNumbers, $this->numberToTheLeft($lines[0], $y-1));
                $surroundingNumbers = array_merge($surroundingNumbers, $this->numberToTheRight($lines[0], $y+1));
                return $surroundingNumbers[0] * $surroundingNumbers[1];
            }
        }
        return 0;
    }

    private function getSubOfCharactersInALine(string $line, int $firstIndex, int $subsetLength): array
    {
        $items = [];
        for ($h = 0; $h <= $subsetLength; $h++) {
            $items[] = $line[$firstIndex + $h];
        }
        $potentialIndex = $firstIndex + 1 + $subsetLength;
        if ($potentialIndex < strlen($line)){
            $items[] = $line[$potentialIndex];
        }
        return $items;
    }

    private function characterIsADigit(string $character): int|false
    {
        return preg_match('/\d/', $character);
    }

    private function isSpecialCharacter(string $character): bool
    {
        return $character !== '.' && !$this->characterIsADigit($character);
    }

    private function endOfLine(int $y, int $lineLength): bool
    {
        return $y + 1 === $lineLength;
    }

    private function numberToTheLeft(string $line, $neighborIndex): array
    {
        $number = '';
        for ($x = $neighborIndex; $x >= 0; $x--) {
            $number = $line[$x] . $number;
        }
        return [(int) $number];
    }

    private function numberToTheRight(string $line, $neighborIndex): array
    {
        $number = '';
        for ($x = $neighborIndex; $x < strlen($line); $x++) {
            $character = $line[$x];
            $number .= $character;
        }
        return [(int) $number];
    }
}