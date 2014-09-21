# RawErrorHandler - A Simple Error Handler Class for PHP Applications

[![Build Status](https://travis-ci.org/rawphp/RawErrorHandler.svg?branch=master)](https://travis-ci.org/rawphp/RawErrorHandler) [![Coverage Status](https://coveralls.io/repos/rawphp/RawErrorHandler/badge.png)](https://coveralls.io/r/rawphp/RawErrorHandler)
[![Latest Stable Version](https://poser.pugx.org/rawphp/raw-error-handler/v/stable.svg)](https://packagist.org/packages/rawphp/raw-error-handler) [![Total Downloads](https://poser.pugx.org/rawphp/raw-error-handler/downloads.svg)](https://packagist.org/packages/rawphp/raw-error-handler) 
[![Latest Unstable Version](https://poser.pugx.org/rawphp/raw-error-handler/v/unstable.svg)](https://packagist.org/packages/rawphp/raw-error-handler) [![License](https://poser.pugx.org/rawphp/raw-error-handler/license.svg)](https://packagist.org/packages/rawphp/raw-error-handler)

## Package Features
- Setup error and exception handlers
- Setup custom callbacks

## Installation

### Composer
RawErrorHandler is available via [Composer/Packagist](https://packagist.org/packages/rawphp/raw-error-handler).

Add `"rawphp/raw-error-handler": "0.*@dev"` to the require block in your composer.json and then run `composer install`.

```json
{
        "require": {
            "rawphp/raw-error-handler": "0.*@dev"
        }
}
```

You can also simply run the following from the command line:

```sh
composer require rawphp/raw-error-handler "0.*@dev"
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

// instantiate error handler
$handler = new ErrorHandler( );

// config array is optional
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

#### 22-09-2014
- Updated to PHP 5.3.

#### 18-09-2014
- Updated to work with the latest rawphp/rawbase package.

#### 14-09-2014
- Implemented the hook system.
- Removed `init()` call from constructor.

#### 12-09-2014
- Initial Code Commit.