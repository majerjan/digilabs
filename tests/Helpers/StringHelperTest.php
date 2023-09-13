<?php
declare(strict_types=1);

namespace Tests\Helpers;

use App\Exceptions\InvalidNameException;
use App\Helpers\StringHelper;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringHelperTest extends TestCase {

    /**
     * @return array<array<int, string|bool>>
     */
    public static function createHaveEqualNameSurnameCharsProvider(): array {
        return [
            ['Dlaise Arie Damarys', true, true, true],
            ['Dlaise Arie damarys', true, true, false],
            ['Blaise Arie damarys', true, true, false],
            ['Blaise Arie Damarys', true, true, false],

            ['Dlaise Arie Damarys', true, false, true],
            ['Dlaise Arie damarys', true, false, true],
            ['Blaise Arie damarys', true, false, false],
            ['Blaise Arie Damarys', true, false, false],

            ['Alaise Drie Damarys', false, true, true],
            ['Alaise Drie damarys', false, true, false],
            ['Blaise Arie damarys', false, true, false],
            ['Blaise Arie Damarys', false, true, false],

            ['Alaise Drie Damarys', false, false, true],
            ['Alaise Drie damarys', false, false, true],
            ['Blaise Arie damarys', false, false, false],
            ['Blaise Arie Damarys', false, false, false],
        ];
    }

    #[DataProvider('createHaveEqualNameSurnameCharsProvider')]
    public function testHaveEqualNameSurnameChars(string $name, bool $onlyFirstName, bool $caseSensitive, bool $expected): void {
        $helper = new StringHelper();
        $match = $helper->haveEqualNameSurnameChars($name, $onlyFirstName, $caseSensitive);

        Assert::assertSame($expected, $match);
    }

    /**
     * @return array<array<int,string|bool>>
     */
    public static function createHaveEqualNameSurnameCharsExceptionProvider(): array {
        return [
            ['', true, true],
            ['', true, false],
            ['', false, true],
            ['', false, false],

            ['name', true, true],
            ['name', true, false],
            ['name', false, true],
            ['name', false, false],
        ];
    }

    #[DataProvider('createHaveEqualNameSurnameCharsExceptionProvider')]
    public function testHaveEqualNameSurnameCharsException(string $name, bool $onlyFirstName, bool $caseSensitive): void {
        $helper = new StringHelper();

        $this->expectException(InvalidNameException::class);
        $helper->haveEqualNameSurnameChars($name, $onlyFirstName, $caseSensitive);
    }

    /**
     * @return array<array<int,string|bool>>
     */
    public static function createHaveEqualEquationProvider(): array {
        return [
            ['20 - 47 = -27', true],
            ['74 = 54 + 58', false],
            ['17 = 31 - 51', false],
            ['97 + 49 = 146', true],
            ['1 + 5 = 6', true],
            ['116 + 115 = 231', true],

        ];
    }

    #[DataProvider('createHaveEqualEquationProvider')]
    public function testHaveEqualEquationException(string $equation, bool $expected): void {
        $helper = new StringHelper();

        $equal = $helper->haveEqualEquation($equation);
        Assert::assertSame($expected, $equal);
    }
}