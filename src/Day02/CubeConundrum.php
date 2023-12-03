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
            $sets = $this->determinePiecesSets($game);
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
            $numberOfCubes = 0;
            if (str_contains($cubes, $color)) {
                $numberOfCubes = (int)str_replace(" $color", '', $cubes);
            }
            return  max($numberOfCubes, $maxNumber);
        }, 0);
    }

    private function determinePiecesSets(string $game): array|false
    {
        $gamePieces = explode(': ', $game)[1];
        return preg_split('/; |, /', $gamePieces);
    }

    private function isValidGame(array $sets): bool
    {
        return !$this->anyNumberOfCubesToBigForColor($sets, 'blue', 14)
            && !$this->anyNumberOfCubesToBigForColor($sets, 'green', 13)
            && !$this->anyNumberOfCubesToBigForColor($sets, 'red', 12);
    }
}