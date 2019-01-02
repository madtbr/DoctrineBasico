<?php

use App\Entity\Category;
use App\Entity\Post;
use Aura\Router\RouterContainer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
$request  =\Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$view = new \Slim\Views\PhpRenderer(__DIR__.'/../templates/');
//requisição do cliente e a resposta do servidor
//mesmo pra uma aplicação pequena qdo se mistura html e afins a coisa fica complicada de ler/escrever e dar manutenção
$map->get('home','/home',function($request,$response) use ($view){
    return $view->render($response,'home.phtml',[
        'teste' => 'Slim PHP view funcionando'
    ]);
});
$matcher = $routerContainer->getMatcher();

//senao combinar nenhuma rota recebe false
$route = $matcher->match($request);

foreach($route->attributes as $key => $value){
    $request = $request->withAttribute($key,$value);
}

$callable = $route->handler;
$response = $callable($request, new Response());
echo $response->getBody();