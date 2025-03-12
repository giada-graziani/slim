<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class HelloController{

    public function hello(Request $request, Response $response, array $args){
        $response->getBody()->write("Hello world");
        return $response;
    }

    public function hello_with_name(Request $request, Response $response, array $args){
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    }

    public function json_name(Request $request, Response $response, array $args){
        $name = $args['name'];
        $response->getBody()->write("{'nome':'$name'}");
        return $response->withHeader('Content-Type', 'application/json');
    }

    
}
?> 