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
 * @package   RawPHP\RawErrorHandler\Contract
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawErrorHandler\Contract;

use Exception;

/**
 * An error handler interface.
 *
 * @category  PHP
 * @package   RawPHP\RawErrorHandler\Contract
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
interface IErrorHandler
{
    /**
     * Initialises the error handler.
     *
     * @param array $config configuration array
     */
    public function init( $config = [ ] );

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
    public function handleError( $errno, $message = '', $file = '', $line = '', $context = [ ] );

    /**
     * Handles exceptions.
     *
     * @param Exception $exception the exception
     *
     * @return bool TRUE
     */
    public function handleException( Exception $exception );

    /**
     * Returns a list of traces for the error or exception.
     *
     * @param array $trace original debug backtrace
     *
     * @return array processed backtrace
     */
    public function getBacktrace( $trace );
}