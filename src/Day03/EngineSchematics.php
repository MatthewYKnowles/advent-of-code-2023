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
        $surroundingNumbers = [];
        for ($x = 0; $x <= count($lines); $x++) {
            for ($y = 0; $y <= $lineLength; $y++) {
                $character = $lines[$x][$y];
                if ($character === '*') {
                    if($x-1 >= 0) {
                        $surroundingNumbers = array_merge($surroundingNumbers, $this->numbersOnNeighborLine($lines[$x-1], $y-1));
                    }
                    if($x+1 < count($lines)) {
                        $surroundingNumbers = array_merge($surroundingNumbers, $this->numbersOnNeighborLine($lines[$x+1], $y-1));
                    }
                    $surroundingNumbers = array_merge($surroundingNumbers, $this->numberToTheLeft($lines[$x], $y-1));
                    $surroundingNumbers = array_merge($surroundingNumbers, $this->numberToTheRight($lines[$x], $y+1));
                    if (count($surroundingNumbers) === 2) {
                        $sumOfRatios += $surroundingNumbers[0] * $surroundingNumbers[1];
                    }
                    $surroundingNumbers = [];
                }
            }
        }

        return $sumOfRatios;
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

    private function numberToTheLeft(string $line, int $neighborIndex): array
    {
        $number = '';
        for ($x = $neighborIndex; $x >= 0; $x--) {
            $character = $line[$x];
            if (!$this->characterIsADigit($character)) {
                break;
            }
            $number = $character . $number;
        }
        if (strlen($number) > 0) {
            return [(int) $number];
        }
        return [];
    }

    private function numberToTheRight(string $line, int $neighborIndex): array
    {
        $number = '';
        for ($x = $neighborIndex; $x < strlen($line); $x++) {
            $character = $line[$x];
            if (!$this->characterIsADigit($character)) {
                break;
            }
            $number .= $character;
        }
        if (strlen($number) > 0) {
            return [(int) $number];
        }
        return [];
    }

    private function numbersOnNeighborLine(string $line, int $neighborIndex)
    {
        $numbers = [];
        $number = '';
        $index = max($neighborIndex, 0);
        while ($index >= 0) {
            $character = $line[$index];
            if (!$this->characterIsADigit($character)) {
                $index++;
                break;
            } else {
                $index--;
            }
        }
        $index = max($index, 0);
        while ($index <= strlen($line)){
            $character = $line[$index];
            if (!$this->characterIsADigit($character)) {
                if (strlen($number) > 0){
                    $numbers[] = (int) $number;
                    $number = '';
                }
                break;
            }
            $number .= $character;
            $index++;
        }

        if ($index === $neighborIndex) {
            $index++;
            while ($index <= strlen($line)){
                $character = $line[$index];
                if (!$this->characterIsADigit($character)) {
                    if (strlen($number) > 0){
                        $numbers[] = (int) $number;
                        $number = '';
                    }
                    break;
                }
                $number .= $character;
                $index++;
            }
        }

        if ($index < $neighborIndex + 2) {
            $index++;
            while ($index <= strlen($line)){
                $character = $line[$index];
                if (!$this->characterIsADigit($character)) {
                    if (strlen($number) > 0){
                        $numbers[] = (int) $number;
                        $number = '';
                    }
                    break;
                }
                $number .= $character;
                $index++;
            }
        }

        return $numbers;
    }
}