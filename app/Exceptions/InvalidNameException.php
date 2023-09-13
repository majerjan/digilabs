<?php
declare(strict_types=1);

namespace App\Exceptions;

class InvalidNameException extends \Exception {

    public function __construct(
        string $name = "",
    ) {
        parent::__construct(sprintf('Invalid name "%s"', $name));
    }
}