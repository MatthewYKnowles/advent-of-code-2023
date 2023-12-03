<?php
declare(strict_types=1);

namespace Day03;

use PHPUnit\Framework\TestCase;

class EngineSchematicsTests extends TestCase
{
    private EngineSchematics $engineSchematics;

    protected function setUp(): void
    {
        parent::setUp();
        $this->engineSchematics = new EngineSchematics();
    }

    public static function games(): array
    {
        return [
            ['1*', 1],
            ['2*', 2],
            ['2*2', 4],
        ];
    }

    /** @dataProvider games */
    public function test1(string $engineSchematics, int $sumOfEngineSchematicNumbers): void
    {
        $result = $this->engineSchematics->determineSumOfPartNumbers($engineSchematics);

        static::assertSame($sumOfEngineSchematicNumbers, $result);
    }
}