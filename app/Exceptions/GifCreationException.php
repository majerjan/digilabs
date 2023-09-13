<?php
declare(strict_types=1);

namespace App\Exceptions;

class GifCreationException extends \Exception {

    public function __construct() {
        parent::__construct(sprintf('%s', 'Gif creation failed'));
    }
}