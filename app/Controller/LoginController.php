<?php
declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Common\Lib\Token;
use App\Request\LoginRequest;
use Hyperf\DbConnection\Db;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;
use Laminas\Stdlib\RequestInterface;

class LoginController extends AbstractController{
    public function index(RenderInterface $render){

        return $render->render('login/index',['name'=>'Hyperf']);
    }

    public function login(LoginRequest $request,ResponseInterface $response){
        $request->validated();

        $post = $request->post();

        $user = Db::table('wolive_service')->select(['service_id','user_name','nick_name'])->where('user_name',$post['username'])->first();
        if (!$user){
            return $response->withStatus(422)->withBody(new SwooleStream(json_encode(['content'=>'用户不存在'])));
        }
        $user = Db::table('wolive_service')->select(['service_id','user_name','nick_name'])->where('user_name',$post['username'])->where('password',md5($post['username'] . "hjkj" . $post['password']))->first();

        if (!$user){
            return $response->withStatus(422)->withBody(new SwooleStream(json_encode(['content'=>'用户或密码错误'])));
        }
        $user['token'] = Token::createToken($user['user_name']);
        $user['code'] = 200;
        return $user;
    }
}
