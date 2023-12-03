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
            $sets = explode('; ', $gameNumberAndPieces[1]);
            if ($this->isValidGame($sets)){
                $total += $gameNumber;
            };
        }
        return $total;
    }

    public function determineSumOfPowerOfFewestCubes(string $gamesInput): int {
        $games = explode("\n", $gamesInput);
        return array_reduce($games, fn (int $total, string $game) => $total + $this->determinePowerOfMinimumSetOfCubes($game), 0);
    }

    private function anyNumberOfCubesToBigForColor(array $subsets, string $color, int $maxNumber): mixed
    {
        return array_reduce($subsets, function (bool $tooBig, string $cubes) use ($color, $maxNumber) {
            if (str_contains($cubes, $color)) {
                $number = (int)str_replace(" $color", '', $cubes);
                $tooBig = $tooBig || $number > $maxNumber;
            }
            return $tooBig;
        }, false);
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

    private function isValidGame(array $sets): bool
    {
        foreach ($sets as $set) {
            $subsets = explode(', ', $set);
            if ($this->anyNumberOfCubesToBigForColor($subsets, 'red', 12)){
                return false;
            };
            if ($this->anyNumberOfCubesToBigForColor($subsets, 'green', 13)){
                return false;
            };
            if ($this->anyNumberOfCubesToBigForColor($subsets, 'blue', 14)){
                return false;
            };
        }
        return true;
    }
}