<?php
declare(strict_types=1);

namespace Day02;

use Day01\Trebuchet;
use PHPUnit\Framework\TestCase;

class CubeConundrumTests extends TestCase
{
    private CubeConundrum $cubeConundrum;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cubeConundrum = new CubeConundrum();
    }

    public static function games(): array
    {
        return [
            ['Game 1: 1 red', 1],
            ['Game 2: 1 red', 2],
            ['Game 1: 12 red', 1],
            ['Game 1: 13 red', 0],
            ['Game 1: 13 green', 1],
            ['Game 1: 14 green', 0],
            ['Game 1: 14 blue', 1],
            ['Game 1: 15 blue', 0],
            ['Game 1: 14 blue, 1 blue', 0],
            ['Game 1: 13 green, 1 green', 0],
            ['Game 1: 12 red, 1 red', 0],
            ['Game 1: 12 red, 1 green, 4 blue', 1],
            ['Game 1: 12 red; 13 red', 0],
        ];
    }

    /** @dataProvider games */
    public function testCalibrationSummationOnlyArabicNumbers(string $game, int $sumOfPossibleGames): void {
        $result = $this->cubeConundrum->determineSumOfPossibleGames($game);

        static::assertSame($sumOfPossibleGames, $result);
    }
}