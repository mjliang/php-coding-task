<?php

namespace MjLiang\PhpCodingTask\task2;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

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
                $response = $this->getHandler($request, $response);
                break;
            case 'POST':
                $response = $this->postHandler($request, $response);
                break;
            case 'PUT':
                $response = $this->putHandler($request, $response);
                break;
            case 'PATCH':
                $response = $this->patchHandler($request, $response);
                break;
            case 'DELETE':
                $response = $this->deleteHandler($request, $response);
                break;
            default:
                $response = $this->defaultHandler($request, $response);
        }

        return $response;
    }


    //============= request Handlers ==================
    protected function getHandler(ServerRequestInterface $request, ResponseInterface $response)
    {
        if ($this->isJsonRequest($request)) {
            $response = $this->renderJson($response, json_encode([
                'message' => 'This is Get Request'
            ]));
        } else if ($this->isFormRequest($request)) {
            $response = $this->renderHtml($response, 'This is Get Request');
        } else {
            $response = $response->withStatus('404', 'Other Content Type handlers have not been implemented');
        }

        return $response;
    }

    protected function postHandler(ServerRequestInterface $request, ResponseInterface $response)
    {

        if ($this->isJsonRequest($request)) {

            if ($this->isValidJsonRequest($request)) {

                $response = $this->renderJson($response, json_encode([
                    'status' => 'success'
                ]));

            } else {
                $response = $response->withStatus('400', 'Bad Request');
            }

        } else if ($this->isFormRequest($request)) {

            if ($this->isValidFormRequest($request)) {

                $responseBody = '<h1>success</h1>';

                $response = $this->renderHtml($response, $responseBody);
            } else {
                $response = $response->withStatus('400', 'Bad Request');
            }

        } else {
            $response = $response->withStatus('404', 'Other Content Type handlers have not been implemented');
        }

        return $response;
    }


    protected function putHandler(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->postHandler($request, $response);
    }

    protected function patchHandler(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response = $response->withStatus(200);
        return $response;
    }


    protected function deleteHandler(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response = $response->withStatus(200);
        return $response;
    }


    protected function defaultHandler(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response = $response->withStatus('404', 'Method not Found');
        return $response;
    }


    protected function isJsonRequest(ServerRequestInterface $request): bool
    {
        return (@$request->getHeader('Content-Type')[0] == 'application/json') ? true : false;
    }


    protected function isFormRequest(ServerRequestInterface $request): bool
    {
        if (@$request->getHeader('Content-Type')[0] == 'application/x-www-form-urlencoded'
            or @$request->getHeader('Content-Type')[0] == 'multipart/form-data') {
            return true;
        }

        return false;
    }

    //============= Validators ==================
    protected function isValidJsonRequest(ServerRequestInterface $request): bool
    {
        $body = (string)$request->getBody();
        $body = json_decode($body);

        if ($body && $body->Hello == 'World') {
            return true;
        }

        return false;
    }

    protected function isValidFormRequest(ServerRequestInterface $request): bool
    {
        $body = $request->getParsedBody();

        if ($body && !empty($body['Hello']) && $body['Hello'] == 'World') {
            return true;
        }

        return false;
    }

    //============= Helpers ==================
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