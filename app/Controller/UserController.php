<?php

namespace App\Controller;

use App\Request\UserRequest;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Request;

class UserController extends AbstractController
{
    public function getUserList(Request $request)
    {
        $user = Db::table('wolive_service')->get();

        return $this->result(200, '操作成功', ['user' => $user]);
    }

    public function editUser(UserRequest $request)
    {
        $request->validated();
        $post = $request->post();

        $data = [
            'user_name' => $post['user_name'],
            'nick_name' => $post['nick_name'],
            'password' => md5($post['user_name'] . "hjkj" . $post['password']),
            'phone' => $post['phone'],
            'email' => $post['email'],
        ];

        if ($post['service_id']) {
            $result = Db::table('wolive_service')->where('service_id', $post['service_id'])->update($data);
        } else {
            $result = Db::table('wolive_service')->insert($data);
        }
        if ($result) {
            return $this->result(200, '操作成功', []);
        }

        return $this->result(500, '操作失败', []);
    }

    /**
     * 建立聊天
     * @param Request $request
     * @return array
     */
    public function buildChat(Request $request){
        $data = $request->getParsedBody();
        $from_service_id = $data['from_service_id'];
        $to_service_id = $data['to_service_id'];
        $chat = Db::table('wolive_chat')
            ->where([['from_service_id', '=', $from_service_id], ['to_service_id', '=', $to_service_id]])
            ->orWhere([['to_service_id', '=', $from_service_id], ['from_service_id', '=', $to_service_id]])
            ->first();

        if (!$chat) {
            $id = Db::table('wolive_chat')->insertGetId([
                'from_service_id' => $from_service_id,
                'to_service_id' => $to_service_id,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $id = $chat['cid'];
        }

        return $this->result(200,'发起聊天成功',['cid'=>$id]);
    }
}
