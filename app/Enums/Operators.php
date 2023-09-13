<?php
declare(strict_types=1);

namespace App\Enums;

enum Operators: string {
    case EQUAL = '=';
    case PLUS = '+';
    case MINUS = '-';
}