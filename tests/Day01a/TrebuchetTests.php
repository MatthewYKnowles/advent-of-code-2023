<?php
declare(strict_types=1);

namespace Day01a;

use PHPUnit\Framework\TestCase;

class TrebuchetTests extends TestCase
{
    public function testSingleNumber(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument = '1';

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        static::assertSame(11, $result);
    }

    public function testDifferentSingleNumber(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument = '2';

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        static::assertSame(22, $result);
    }
    public function testWithLetters(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument = 'd2fdsaf';

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        static::assertSame(22, $result);
    }
    public function testWithTwoDigits(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument = 'd2fdsa3f';

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        static::assertSame(23, $result);
    }

    public function testWithThreeDigits(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument = 'd2fdsa3f5tr';

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        static::assertSame(25, $result);
    }

    public function testWithMultipleLines(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument =
"1
2";

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        static::assertSame(33, $result);
    }
}
