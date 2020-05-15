# Exception utils

[![Build Status](https://travis-ci.org/mostofreddy/exception-utils.svg?branch=master)](https://travis-ci.org/mostofreddy/exception-utils)
[![Coverage Status](https://coveralls.io/repos/github/mostofreddy/exception-utils/badge.svg?branch=master)](https://coveralls.io/github/mostofreddy/exception-utils?branch=master)

Utilities exception handling

## Features

* Define the application context when an exception is thrown
* Exception format for logs

## Exceptions context

The context of an exception allows us to know the state of the application when an exception occurs. This context can be retrieved for later saving and analysis.

__Ejemplo__

CustomException.php

```php
class CustomException extends Exception
{
    use ExceptionContextTrait;
}
```

MyService.php

```php
class MyService
{
    // code...

    public function foo(int $id): Model
    {
        $model = $this->repository->find($id);
        if (is_null($model)) {
             throw (new CustomException('Model not found'))
                ->setContext([
                    'id' => $id
                    // ...
                ]);
        }
        // code...
    }
}
```

index.php

```php
try {
    $service = new MyService();
    $service->foo(1234);
} catch (CustomException $e) {
    echo "Error: " . $e->getMessage();
    echo "Context: " . print_r($e->getContext(), true);
}

// Result

// Error: Model not foundContext: Array
// (
//     [id] => 1234
// )
```

## Formatting expections

```php
try {
    $service = new MyService();
    $service->foo(1234);
} catch (CustomException $e) {
    echo print_r(ExceptionFormatter::format($e), true);
}

// Result

// Array
// (
//     [exception] => CustomException
//     [message] => Model not found
//     [code] => 0
//     [file] => /home/freddy/Code/smarttly/exceptions/examples/example.php:21
//     [triggered] => MyService->foo()
//     [context] => Array
//         (
//             [id] => 1234
//         )

//     [trace] => #0 /home/freddy/Code/smarttly/exceptions/examples/example.php(31): MyService->foo(1234)
// #1 {main}
// )
```
