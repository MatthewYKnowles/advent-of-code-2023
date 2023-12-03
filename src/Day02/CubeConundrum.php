<?php
declare(strict_types=1);

namespace Day02;

class CubeConundrum
{
    public function determineSumOfPossibleGames(string $gamesInput): int {
        $games = explode("\n", $gamesInput);
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

    public function determineSumOfPowerOfFewestCubes(string $gamesInput): int {
        $games = explode("\n", $gamesInput);
        return array_reduce($games, fn (int $total, string $game) => $total + $this->determinePowerOfMinimumSetOfCubes($game), 0);
    }

    private function collectNumbersOfAColor(array $subsets, string $color): mixed
    {
        return array_reduce($subsets, function (array $numbers, string $cubes) use ($color) {
            if (str_contains($cubes, $color)) {
                $numbers[] = (int)str_replace(" $color", '', $cubes);
            }
            return $numbers;
        }, []);
    }

    private function determinePowerOfMinimumSetOfCubes(string $game): int
    {
        $sets = $this->determinePiecesSets($game);
        $minimumRedPieces = $this->determineMinimumPiecesRequired($sets, 'red');
        $minimumGreenPieces = $this->determineMinimumPiecesRequired($sets, 'green');
        $minimumBluePieces = $this->determineMinimumPiecesRequired($sets, 'blue');
        return $minimumRedPieces * $minimumGreenPieces * $minimumBluePieces;
    }

    private function determineMinimumPiecesRequired(array $subsets, string $color): mixed
    {
        return array_reduce($subsets, function (int $maxNumber, string $cubes) use ($color) {
            if (str_contains($cubes, $color)) {
                $numberOfCubes = (int)str_replace(" $color", '', $cubes);
                $maxNumber = max($numberOfCubes, $maxNumber);
            }
            return $maxNumber;
        }, 0);
    }

    private function determinePiecesSets(string $game): array|false
    {
        $gamePieces = explode(': ', $game)[1];
        return preg_split('/; |, /', $gamePieces);
    }
}