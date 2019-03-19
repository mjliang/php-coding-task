<?php

namespace MjLiang\PhpCodingTask\task2;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Stream;

class Controller
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response)
    {
        $method = $request->getMethod();

        switch ($method) {
            case 'GET':
                $response = $this->renderHtml($response, 'This is Get Request');
                break;
            case 'PUT':
            case 'POST':
                if(@$request->getHeader('Content-Type')[0] == 'application/json') {
                    $body = (string) $request->getBody();
                    $body = json_decode($body);

                    if($body && $body->Hello == 'World') {


                        $response = $this->renderJson($response, json_encode([
                            'status' => 'success'
                        ]));

                    } else {
                        $response = $response->withStatus('400', 'Bad Request');
                    }

                } else if(
                    @$request->getHeader('Content-Type')[0] == 'application/x-www-form-urlencoded'
                    or @$request->getHeader('Content-Type')[0] == 'multipart/form-data'
                ) {

                    $body = $request->getParsedBody();

                    if($body && !empty($body['Hello']) && $body['Hello'] == 'World') {

                        $responseBody = '<h1>success</h1>';

                        $response = $this->renderHtml($response, $responseBody);
                    } else {
                        $response = $response->withStatus('400', 'Bad Request');
                    }

                } else {
                    //@TODO handle by other stuff
                    $response = $response->withStatus('404', 'Other Content Type handlers have not been implemented');
                }
                break;
            default:
                $response = $response->withStatus('404', 'Method not Found');
        }


        return $response;
    }


    protected function renderHtml(ResponseInterface $response, string $content)
    {
        $response->getBody()->write($content);
        $response = $response->withStatus('200')
            ->withHeader('Content-Type', 'text/html; charset=utf-8');

        return $response;
    }

    protected function renderJson(ResponseInterface $response, string $content)
    {
        $response->getBody()->write($content);
        $response = $response->withStatus('200')
            ->withHeader('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }


}