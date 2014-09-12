
# RawErrorHandler - A Simple Error Handler Class for PHP Applications

## Class Features

- 

## Installation

### Composer
RawErrorHandler is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-error-handler).

Add `"rawphp/raw-error-handler": "dev-master"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-error-handler": "dev-master"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-error-handler "dev-master"
```

### Tarball
Alternatively, just copy the contents of the RawErrorHandler folder into somewhere that's in your PHP `include_path` setting. If you don't speak git or just want a tarball, click the 'zip' button at the top of the page in GitHub.

## Basic Usage

```php
<?php

use RawPHP\RawErrorHandler\ErrorHandler;

// optional configuration
$config = array(
    'error_callback'     => array( $this, 'errorCallback' ),
    'exception_callback' => array( $this, 'exceptionCallback' ),
    'shutdown_callback'  => array( $this, 'shutdownCallback' ),
);

// instantiate error handler - config array is optional
$handler = new ErrorHandler( $config );

// you can also initialise the handler by calling `init( )`
$handler->init( $config );

// callbacks
public function errorCallback( $error )
{
    // handle the error trace
}

public function exceptionCallback( $exception )
{
    // handle the exception trace
}

public function shutdownCallback( )
{
    // do any required cleanup
}

```

## License
This package is licensed under the [MIT](https://github.com/rawphp/RawErrorHandler/blob/master/LICENSE). Read LICENSE for information on the software availability and distribution.

## Contributing

Please submit bug reports, suggestions and pull requests to the [GitHub issue tracker](https://github.com/rawphp/RawErrorHandler/issues).

## Changelog

#### 12-09-2014
- Initial Code Commit
