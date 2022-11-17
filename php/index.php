<?php
require './vendor/autoload.php';
require './utils/CommonFunction.php';
require './utils/HashFunction.php';
require './utils/JWTFunction.php';
require './config/Database.php';
require './config/Secret.php';
require './config/BaseResponseStatus.php';

use Monolog\Handler\RotatingFileHandler;
use \Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

// Logger 채널 생성
$accessLogs = new Logger('ACCESS_LOGS');
$errorLogs = new Logger('ERROR_LOGS');
$accessLogs->pushHandler(new RotatingFileHandler('logs/access.log', Logger::INFO));
$errorLogs->pushHandler(new RotatingFileHandler('logs/errors.log', Logger::ERROR));


date_default_timezone_set('Asia/Seoul');
ini_set('default_charset', 'utf8mb4');

// 에러출력하게 하는 코드
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

// TODO: 도메인 별 그룹 짓기
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
//    $r->addRoute('GET', '/app/test', ['User', 'test']); // DB 연결 없이 TEST

    // User
    $r->addRoute('POST', '/app/users', ['User', 'createUserInfo']); // 유저 생성 API

    $r->addRoute('GET', '/app/users', ['User', 'retrieveUserInfo']); // 유저 조회 API -- DB 연결 테스트

    $r->addRoute('GET', '/app/users/{userId}', ['User', 'retrieveUserInfoById']); // 특정 유저 조희 API

    $r->addRoute('POST', '/app/token', ['User', 'login']); // JWT Token 발금 API
    $r->addRoute('PATCH', '/app/users/{userId}', ['User', 'patchUsers']); // 유저 닉네임 수정 API

    // Board
//    $r->addRoute('POST', '/app/boards', ['Board', 'createBoard']); // 게시판 생성 API

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1][1];
        $vars = $routeInfo[2]; // Path Variable
        require "./src/".(string)$routeInfo[1][0]."/".(string)$routeInfo[1][0]."Controller.php";
        break;
}

