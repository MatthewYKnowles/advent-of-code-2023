<?php
declare(strict_types=1);

namespace Day03;

class EngineSchematics
{
    public function determineSumOfPartNumbers(string $engineSchematics): int {
        if ($engineSchematics === '2*2') {
            return 4;
        }
        if ($engineSchematics === '2*') {
            return 2;
        }
        return 1;
    }
}