<?php
declare(strict_types=1);

namespace Day02;

class CubeConundrum
{
    public function determineSumOfPossibleGames(string $gamessomething): int {
        $games = explode("\n", $gamessomething);
        $total = 0;
        foreach ($games as $game) {
            $gameNumberAndPieces = explode(': ', $game);
            $gameNumber = (int) str_replace('Game ', '', $gameNumberAndPieces[0]);
            $valid = true;
            $sets = explode('; ', $gameNumberAndPieces[1]);
            foreach ($sets as $set) {
                if (str_contains($set, 'red')) {
                    $subsets = explode(', ', $set);
                    $numbers = $this->collectNumbersOfAColor($subsets, 'red');
                    foreach ($numbers as $number) {
                        if ($number > 12) {
                            $valid = false;
                        }
                    }
                }
                if (str_contains($set, 'green')) {
                    $subsets = explode(', ', $set);
                    $numbers = $this->collectNumbersOfAColor($subsets, 'green');
                    foreach ($numbers as $number) {
                        if ($number > 13) {
                            $valid = false;
                        }
                    }
                }
                if (str_contains($set, 'blue')) {
                    $subsets = explode(', ', $set);
                    $numbers = $this->collectNumbersOfAColor($subsets, 'blue');
                    foreach ($numbers as $number) {
                        if ($number > 14) {
                            $valid = false;
                        }
                    }
                }
            }
            if ($valid){
                $total += $gameNumber;
            }
        }

        return $total;
    }

    public function determine2(string $gamessomething): int {
        $games = explode("\n", $gamessomething);
        $total = 0;
        foreach ($games as $game) {
            $gameNumberAndPieces = explode(': ', $game);
            $gameNumber = (int) str_replace('Game ', '', $gameNumberAndPieces[0]);
            $valid = true;
            $sets = preg_split('/; |, /', $gameNumberAndPieces[1]);
            $redNumbers = $this->collectNumbersOfAColor($sets, 'red');
            $greenNumbers = $this->collectNumbersOfAColor($sets, 'green');
            $blueNumbers = $this->collectNumbersOfAColor($sets, 'blue');

            $total += max($redNumbers) * max($greenNumbers) * max($blueNumbers);
        }

        return $total;
    }

    public function DertermineTotalNumberOfCubes(array $subsets, string $color): int
    {
        return array_reduce($subsets, function (int $total, string $cubes) use ($color) {
            if (str_contains($cubes, $color)) {
                return $total += (int)str_replace(" $color", '', $cubes);
            }
            return $total;
        }, 0);
    }

    public function collectNumbersOfAColor(array $subsets, string $color): mixed
    {
        return array_reduce($subsets, function (array $numbers, string $cubes) use ($color) {
            if (str_contains($cubes, $color)) {
                $numbers[] = (int)str_replace(" $color", '', $cubes);
            }
            return $numbers;
        }, []);
    }
}