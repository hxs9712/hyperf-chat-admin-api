<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Common\Lib\Token;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ValidateToken implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        $token = $request->getHeader('token')[0];

        if (!$token) {
            $response = $response
                ->withStatus(401)
                ->withBody(new SwooleStream('未登录'));
            return $response;
        }
        $username = Token::validateToken($token);
        if (!Token::validateToken($token)) {

            $response = $response
                ->withStatus(401)
                ->withBody(new SwooleStream('token无效'));

            return $response;
        }

        $parseData = $request->getParsedBody();
        if (!isset($parseData['user_name'])) {
            $request = $request->withParsedBody(array_merge($parseData, ['user_name' => $username]));
        }
        return $handler->handle($request);
    }
}
