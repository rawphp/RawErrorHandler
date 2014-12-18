<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 *
 * Copyright (c) 2014 RawPHP.org
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   RawPHP\RawErrorHandler
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawErrorHandler;

use Exception;
use RawPHP\RawErrorHandler\Contract\IErrorHandler;

/**
 * An error handler service.
 *
 * @category  PHP
 * @package   RawPHP\RawErrorHandler
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class ErrorHandler implements IErrorHandler
{
    public $errorCallback = NULL;
    public $exceptionCallback = NULL;
    public $shutdownCallback = NULL;

    /**
     * Initialises the error handler.
     *
     * @param array $config configuration array
     */
    public function init( $config = [ ] )
    {
        if ( isset( $config[ 'error_callback' ] ) )
        {
            $this->errorCallback = $config[ 'error_callback' ];
        }

        if ( isset( $config[ 'exception_callback' ] ) )
        {
            $this->exceptionCallback = $config[ 'exception_callback' ];
        }

        if ( isset( $config[ 'shutdown_callback' ] ) )
        {
            $this->shutdownCallback = $config[ 'shutdown_callback' ];

            register_shutdown_function( $this->shutdownCallback );
        }

        set_error_handler( [ $this, 'handleError' ], E_ALL );

        set_exception_handler( [ $this, 'handleException' ] );
    }

    /**
     * Handles PHP errors that may occur.
     *
     * @param int    $errno   the error no
     * @param string $message error message
     * @param string $file    the file name
     * @param string $line    the line number
     * @param array  $context the error context
     *
     * @return bool TRUE
     */
    public function handleError( $errno, $message = '', $file = '', $line = '', $context = [ ] )
    {
        // restore previous error handler
        restore_error_handler();

        if ( $errno === NULL )
        {
            $error = error_get_last();

            $error = [
                'file'    => $error[ 'file' ],
                'line'    => $error[ 'line' ],
                'message' => $error[ 'message' ],
                'trace'   => $this->getBacktrace( debug_backtrace() ),
            ];
        }
        else
        {
            $error = [
                'message' => $message,
                'file'    => $file,
                'line'    => $line,
                'context' => $context,
            ];
        }

        if ( NULL !== $this->errorCallback )
        {
            call_user_func_array( $this->errorCallback, $error );
        }

        return TRUE;
    }

    /**
     * Handles exceptions.
     *
     * @param Exception $exception the exception
     *
     * @return bool TRUE
     */
    public function handleException( Exception $exception )
    {
        // restore previous exception handler
        restore_exception_handler();

        if ( $exception instanceof Exception )
        {
            $error = [
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'message' => $exception->getMessage(),
                'trace'   => $this->getBacktrace( $exception->getTrace() ),
            ];
        }
        else
        {
            return;
        }

        if ( NULL !== $this->exceptionCallback )
        {
            call_user_func_array( $this->exceptionCallback, $error );
        }

        return TRUE;
    }

    /**
     * Returns a list of traces for the error or exception.
     *
     * @param array $trace original debug backtrace
     *
     * @return array processed backtrace
     */
    public function getBacktrace( $trace )
    {
        $traces = [ ];

        $i = 1;

        foreach ( $trace as $t )
        {
            $traceString = '';

            if ( !isset( $t[ 'file' ] ) )
            {
                $t[ 'file' ] = 'unknown';
            }
            if ( !isset( $t[ 'line' ] ) )
            {
                $t[ 'line' ] = 0;
            }
            if ( !isset( $t[ 'function' ] ) )
            {
                $t[ 'function' ] = 'unknown';
            }

            $traceString .= '#' .
                $i . ' ' .
                $t[ 'file' ] . '(' .
                $t[ 'line' ] . '): ';

            if ( isset( $t[ 'object' ] ) && is_object( $t[ 'object' ] ) )
            {
                $traceString .= get_class( $t[ 'object' ] ) . '->';
            }

            $traceString .= $t[ 'function' ] . '()';

            $traces[ ] = $traceString;

            $i++;
        }

        return $traces;
    }
}