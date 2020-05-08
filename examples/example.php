<?php

include '../vendor/autoload.php';

use Smarttly\ExceptionUtils\{
    ExceptionContextTrait,
    ExceptionFormatter
};

class CustomException extends Exception
{
    use ExceptionContextTrait;
}

function foo($id)
{
    // ... Business logic
    throw (new CustomException('Error Message', 999))
        ->setContext([
            'id' => $id
            // ...
        ]);
}


try {
    $id = rand();
    foo($id);
} catch (Throwable $ex) {
    echo print_r(ExceptionFormatter::format($ex), true);
}
