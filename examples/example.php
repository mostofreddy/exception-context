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

class MyService
{
    // code...

    public function foo(int $id)
    {
        throw (new CustomException('Model not found'))
        ->setContext([
            'id' => $id
        ]);
    }
}


try {
    $service = new MyService();
    $service->foo(1234);
} catch (CustomException $e) {
    echo print_r(ExceptionFormatter::format($e), true);
}
