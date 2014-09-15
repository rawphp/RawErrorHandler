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
 * @package   RawPHP/RawErrorHandler/Tests
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawErrorHandler;

use RawPHP\RawErrorHandler\ErrorHandler;

/**
 * An error handler service.
 * 
 * @category  PHP
 * @package   RawPHP/RawErrorHandler/Tests
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var ErrorHandler
     */
    public $errorHandler        = NULL;
    
    private $_errorHandled      = FALSE;
    private $_exceptionHandled  = FALSE;
    
    /**
     * Setup before each test.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->errorHandler = new ErrorHandler( );
    }
    
    /**
     * Cleanup before each test.
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->errorHandler         = NULL;
        $this->_errorHandled        = FALSE;
        $this->_exceptionHandled    = FALSE;
        
        restore_error_handler();
        restore_exception_handler();
    }
    
    /**
     * Test error handler instantiation.
     */
    public function testErrorHandlerInstantiatedCorrectly( )
    {
        $this->assertNotNull( $this->errorHandler );
    }
    
    /**
     * Test exception handler gets called correctly and it calls the
     * callback method.
     * 
     * @todo Need a better way of testing this
     * 
     * @throws \Exception the test exception
     * 
     * @expectedException \Exception
     */
    public function testExceptionCallbackIsCalledCorrectly( )
    {
        $this->errorHandler->init( array( 'exception_callback' => array( $this, 'exceptionCallback' ) ) );
        
        //$this->setUseErrorHandler( $this->errorHandler );
        
        throw new \Exception( 'my_exception' );
    }
    
    /**
     * Test error callback is called correctly on error.
     */
    public function testErrorCallbackIsCalledCorrectly( )
    {
        $this->errorHandler->init( array( 'error_callback' => array( $this, 'errorCallback' ) ) );
        
        user_error( 'my_error', E_USER_ERROR );
        
        $this->assertTrue( $this->_errorHandled );
    }
    
    /**
     * Helper method called by the system when an error occurs.
     * 
     * @param mixed $error the error
     */
    public function errorCallback( $error )
    {
        $this->assertEquals( 'my_error', $error );
        
        $this->_errorHandled = TRUE;
    }
    
    /**
     * Helper method called by the system when an exception is thrown.
     * 
     * @param array $error error dump
     */
    public function exceptionCallback( $error )
    {
    }
}
