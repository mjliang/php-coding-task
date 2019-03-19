<?php
/**
 * Created by PhpStorm.
 * User: MJ
 * Date: 2019-03-19
 * Time: 21:48
 */

namespace MjLiang\PhpCodingTask\Tests\task2;

use MjLiang\PhpCodingTask\task2\Controller;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Zend\Diactoros\StreamFactory;

class ControllerTest extends TestCase
{

    /**
     * @test
     */
    public function jsonPost()
    {
        $streamFactory = new StreamFactory();
        $stream = $streamFactory->createStream(json_encode([
            'Hello' => 'World'
        ]));

        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'POST',
            $stream,
            [
                'Content-Type'  => 'application/json',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertEquals('{"status":"success"}', (string) $response->getBody());
        $this->assertEquals('application/json; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }

    /**
     * @test
     */
    public function formPost()
    {

        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'POST',
            'php://memory',
            [
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ],
            [],
            [
                'Hello' => 'World'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertEquals('<h1>success</h1>', (string) $response->getBody());
        $this->assertEquals('text/html; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }

    /**
     * @test
     */
    public function getMethod()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'GET',
            'php://memory',
            [
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertEquals('This is Get Request', (string) $response->getBody());
        $this->assertEquals('text/html; charset=utf-8', $response->getHeader('Content-Type')[0]);
    }


    /**
     * @test
     */
    public function deleteMethod()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'DELETE',
            'php://memory',
            [
                'Content-Type'  => 'application/json',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
    }

    public function patchMethod()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'PATCH',
            'php://memory',
            [
                'Content-Type'  => 'application/json',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
    }

    /**
     * @test
     */
    public function otherContentTypeHandlers()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'POST',
            'php://memory',
            [
                'Content-Type'  => 'application/javascript',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('404', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertEquals('Other Content Type handlers have not been implemented', $response->getReasonPhrase());
    }

    /**
     * @test
     */
    public function otherMethodRequest()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'OTHER_METHOD',
            'php://memory',
            [
                'Content-Type'  => 'application/javascript',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('404', $response->getStatusCode());
        $this->assertEquals('Method not Found', $response->getReasonPhrase());
    }


    /**
     * @test
     */
    public function badRequest()
    {
        $request = new ServerRequest(
            [],
            [],
            'http://example.com',
            'POST',
            'php://memory',
            [
                'Content-Type'  => 'application/json',
            ],
            [
                'cookie1' => 'cookie 1 value'
            ]
        );

        $controller = new Controller();

        $response = $controller->execute($request, new Response());

        $this->assertEquals('400', $response->getStatusCode());
        $this->assertInstanceOf(StreamInterface::class, $response->getBody());
        $this->assertEquals('Bad Request', $response->getReasonPhrase());
    }
}
