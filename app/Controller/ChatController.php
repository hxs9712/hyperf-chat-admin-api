<?php

namespace App\Controller;

use App\Request\UserRequest;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Request;

class ChatController extends AbstractController
{
    public function getChatRecord(Request $request)
    {
        $data = $request->getParsedBody();

        //获取聊天记录
        $chat_record = Db::table('wolive_chat_record')
            ->select(['wolive_chat_record.*', 'ws1.user_name as from_username', 'ws2.user_name as to_username',])
            ->join('wolive_service as ws1', 'from_service_id', '=', 'ws1.service_id')
            ->join('wolive_service as ws2', 'to_service_id', '=', 'ws2.service_id')
            ->where('cid', $data['cid'])
            ->get();

        $service = Db::table('wolive_service')->where('service_id',$data['to_service_id'])->first();

        //把消息设置为已读
        Db::table('wolive_chat')->where('cid', $data['cid'])->update(['unread_count' => 0]);

        return $this->result(200, '操作成功', ['chat_record' => $chat_record,'service'=>$service, 'cid' => $data['cid']]);
    }

    public function getUserList(Request $request)
    {
        $self = Db::table('wolive_service')->where('user_name', '=', $request->getParsedBody()['user_name'])->first();

        $allchatcid = Db::table('wolive_chat')
            ->Where([['to_service_id', '=', $self['service_id']]])
            ->orWhere([['from_service_id', '=', $self['service_id']]])
            ->pluck('cid')
            ->toArray();

        $user = Db::table('wolive_chat')
            ->select(['ws1.user_name as from_username', 'ws1.service_id as from_service_id', 'ws2.user_name as to_username', 'ws2.service_id as to_service_id', 'cid', 'wolive_chat.create_time', 'unread_count'])
            ->join('wolive_service as ws1', 'ws1.service_id', '=', 'from_service_id')
            ->join('wolive_service as ws2', 'ws2.service_id', '=', 'to_service_id')
            ->whereIn('cid', $allchatcid)
            ->orderBy('wolive_chat.update_time', 'desc')
            ->get()
            ->toArray();

        $user = array_map(function ($v1) use ($request) {
            if ($v1['from_username'] != $request->getParsedBody()['user_name']) {
                $v1['user_name'] = $v1['from_username'];
                $v1['service_id'] = $v1['from_service_id'];
            } else {
                $v1['user_name'] = $v1['to_username'];
                $v1['service_id'] = $v1['to_service_id'];
            }

            return $v1;
        }, $user);

        return $this->result(200, '操作成功', ['user' => $user]);
    }

    public function buildChatRoom(Request $request)
    {
        $data = $request->getParsedBody();
        $postdata = $request->post();
        $member_id_arr = $postdata['member_id_arr'];
        if (!is_array($member_id_arr) || count($member_id_arr) < 2) {
            return $this->result(500, '聊天室成员至少三人', []);
        }
        $cr_name = $postdata['cr_name'];

        $user = Db::table('wolive_service')->where('user_name', $data['user_name'])->first();

        Db::beginTransaction();
        try {
            $crid = Db::table('wolive_chat_room')->insertGetId([
                'cr_name' => $cr_name,
                'service_id' => $user['service_id'],
                'user_name' => $data['user_name'],
                'create_time' => date("Y-m-d H:i:s"),
                'update_time' => date("Y-m-d H:i:s"),
            ]);


            $insertData = [
                'crid' => $crid,
                'service_id' => $user['service_id'],
                'create_time' => date("Y-m-d H:i:s"),
                'update_time' => date("Y-m-d H:i:s"),
            ];

            foreach ($member_id_arr as $member_id) {
                $insertData[] = [
                    'crid' => $crid,
                    'service_id' => $member_id,
                    'create_time' => date("Y-m-d H:i:s"),
                    'update_time' => date("Y-m-d H:i:s"),
                ];
            }

            Db::table('wolive_chat_room_member')->insert($insertData);
            Db::commit();

            return $this->result(200, '建立聊天室成功', []);
        } catch (\Exception $exception) {
            Db::rollBack();
            var_dump($exception->getMessage());
        }

    }

    public function getChatRoom(Request $request)
    {
        $data = $request->getParsedBody();
        $user = Db::table('wolive_service')->where('user_name', $data['user_name'])->first();

        $chat_room = Db::table('wolive_chat_room_member as crm')
            ->join('wolive_chat_room as cr', 'cr.crid', '=', 'crm.crid')
            ->where('crm.service_id', $user['service_id'])
            ->get();

        return $this->result(200, '获取聊天室成功', ['chat_room' => $chat_room]);
    }

    public function reduceUnread(Request $request)
    {
        $data = $request->post();

        //个人聊天未读消息减1
        if ($data['chatType'] == 1) {
            Db::table('wolive_chat')->where('cid', $data['cid'])->decrement('unread_count', 1);
        }elseif($data['chatType'] == 2){
            //群聊未读消息减1
            Db::table('wolive_chat_room_member')->where('crid', $data['crid'])->decrement('unread_count', 1);
        }

        return $this->result(200,'未读消息减1',[]);
    }

    public function getChatRoomRecord(Request $request)
    {
        $data = $request->getParsedBody();

        $user = Db::table('wolive_service')->where('user_name', $data['user_name'])->first();
        //获取聊天记录
        $chat_record = Db::table('wolive_chat_room_record')
            ->select(['wolive_chat_room_record.*', 'user_name as from_username'])
            ->join('wolive_service as ws1', 'from_service_id', '=', 'ws1.service_id')
            ->where('crid', $data['crid'])
            ->where('to_service_id', $user['service_id'])
            ->orderBy('create_time')
            ->get();

        //把消息设置为已读
        Db::table('wolive_chat_room_member')->where('crid', $data['crid'])->update(['unread_count' => 0]);

        $chat_room = Db::table('wolive_chat_room')->where('crid',$data['crid'])->first();
        return $this->result(200, '操作成功', ['chat_record' => $chat_record,'chat_room'=>$chat_room, 'crid' => $data['crid']]);
    }
}
