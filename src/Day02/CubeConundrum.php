<?php
declare(strict_types=1);

namespace Day02;

class CubeConundrum
{
    public function determineSumOfPossibleGames(string $games): int {
        $gameNumberAndPieces = explode(': ', $games);
        $gameNumber = str_replace('Game ', '', $gameNumberAndPieces[0]);
        $sets = explode('; ', $gameNumberAndPieces[1]);
        foreach ($sets as $set) {
            if (str_contains($set, 'red')) {
                $subsets = explode(', ', $set);
                $numberOfRedCubes = array_reduce($subsets, function (int $total, string $cubes) {
                    if (str_contains($cubes, 'red')) {
                        return $total += (int) str_replace(' red', '', $cubes);
                    }
                    return $total;
                }, 0);
                if ($numberOfRedCubes > 12) {
                    return 0;
                }
            }
            if (str_contains($gameNumberAndPieces[1], 'green')) {
                $subsets = explode(', ', $gameNumberAndPieces[1]);
                $numberOfGreenCubes = array_reduce($subsets, function (int $total, string $cubes) {
                    if (str_contains($cubes, 'green')) {
                        return $total += (int) str_replace(' green', '', $cubes);
                    }
                    return $total;
                }, 0);
                if ($numberOfGreenCubes > 13) {
                    return 0;
                }
            }
            if (str_contains($gameNumberAndPieces[1], 'blue')) {
                $subsets = explode(', ', $gameNumberAndPieces[1]);
                $numberOfBlueCubes = array_reduce($subsets, function (int $total, string $cubes) {
                    if (str_contains($cubes, 'blue')) {
                        return $total += (int) str_replace(' blue', '', $cubes);
                    }
                    return $total;
                }, 0);
                if ($numberOfBlueCubes > 14) {
                    return 0;
                }
            }
        }

        return (int) $gameNumber;
    }
}