<?php
declare(strict_types=1);

namespace Day01a;

use PHPUnit\Framework\TestCase;

class TrebuchetTests extends TestCase
{
    public function testOne(): void {
        $trebuchet = new Trebuchet();
        $calibrationDocument = "1";

        $result = $trebuchet->determineCalibrationValue($calibrationDocument);

        $this->assertEquals(11, $result);
    }
}
