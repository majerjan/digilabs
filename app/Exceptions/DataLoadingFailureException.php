<?php
declare(strict_types=1);

namespace App\Exceptions;

class DataLoadingFailureException extends \Exception {

    public function __construct() {
        parent::__construct(
            'Data loading failed'
        );
    }
}