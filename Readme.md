# Exception utils

## Features

* Set context when exception triggered
* Exception formatter for logs context


## Example

```
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
```

result

```
Array
(
    [exception] => CustomException
    [message] => Error Message
    [code] => 999
    [file] => /home/freddy/Code/smarttly/exceptions/examples/example.php:17
    [triggered] => foo()
    [context] => Array
        (
            [id] => 1565835681
        )

    [trace] => #0 /home/freddy/Code/smarttly/exceptions/examples/example.php(23): foo()
#1 {main}
)
```
