<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Enums\Operators;
use App\Exceptions\InvalidNameException;
use Nette\Utils\Strings;

class StringHelper {

    public function haveEqualNameSurnameChars(
        string $name,
        bool $onlyFirstName,
        bool $caseSensitive = true
    ): bool {
        $chars = $this->getFirstChars($name);

        if(count($chars) < 2) {
            throw new InvalidNameException();
        }

        $surnameChar = array_pop($chars);

        if($onlyFirstName) {
            $chars = [$chars[0]];
        }

        if($caseSensitive === false) {
            $chars = array_map('strtoupper', $chars);
            $surnameChar = Strings::upper($surnameChar);
        }

        return in_array($surnameChar, $chars, true);
    }


    public function haveEqualEquation(string $equation): bool {
        $actual = 0;
        $leftSide = 0;
        $operator = null;

        preg_match_all('/[+-=\d]+/', $equation, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if(is_numeric($match[0])) {
                $number = (float) $match[0];
            } else {
                $operator = Operators::from($match[0]);

                if($operator === Operators::EQUAL) {
                    $leftSide = $actual;
                    $operator = null;
                    $actual = 0;
                }

                continue;
            }

            $actual = match ($operator){
                Operators::PLUS, null => $actual + $number,
                Operators::MINUS => $actual - $number,
                default => $actual
            };
        }

        return $leftSide === $actual;
    }


    /**
     * @return string[]
     */
    private function getFirstChars(string $name): array {
        $chars = [];

        preg_match_all('/[A-z]+/', $name, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $chars[] = Strings::substring($match[0], 0, 1);
        }

        return $chars;
    }
}