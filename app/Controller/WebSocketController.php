<?php
declare(strict_types=1);

namespace App\Controller;

use App\Common\Lib\Token;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\DbConnection\Db;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class WebSocketController extends AbstractController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function onMessage($server, Frame $frame): void
    {

        $data = json_decode($frame->data, true)[0];

        $fd = $frame->fd;
        if (isset($data['to_service_id'])) {
            $service = Db::table('wolive_service')->where('service_id', $data['to_service_id'])->first();
            $fd = $service['fd'];
        }
        //验证token
        $result = $this->validateToken($server, $fd, $data['token']);
        if ($result) {
            $content = '';
            switch ($data['type']) {
                case 1:
                    $content = '已上线';
                    break;
                case 2:
                    $content = $data['content'];
                    break;
            }

            if ($data['chatType'] == 1) {
                Db::table('wolive_chat_record')->insert([
                    'cid' => $data['cid'],
                    'from_service_id' => $data['from_service_id'],
                    'to_service_id' => $data['to_service_id'],
                    'content' => $data['content'],
                    'create_time' => date("Y-m-d H:i:s"),
                    'update_time' => date("Y-m-d H:i:s"),
                ]);

                //更新最新聊天时间
                Db::table('wolive_chat')->where('cid', $data['cid'])->update(['update_time' => date("Y-m-d H:i:s"), 'unread_count' => Db::raw("unread_count+1")]);
                // 判断对方是否在线
                if ($fd && $server->exist($fd)) {
                    $server->push($fd, json_encode(['from_username' => $result, 'content' => $content, 'from_service_id' => $data['from_service_id'], 'to_service_id' => $data['to_service_id'],'crid'=>'']));
                }
            }elseif($data['chatType'] == 2){
                //查询出所有群成员
                $chat_room_members = Db::table('wolive_chat_room_member')->join('wolive_service as ws','ws.service_id','=','wolive_chat_room_member.service_id')->where('crid',$data['crid'])->get()->toArray();
                $insertData = [];
                foreach ($chat_room_members as $member){
                    $insertData[] = [
                        'crid' => $data['crid'],
                        'from_service_id' => $data['from_service_id'],
                        'to_service_id' => $member['service_id'],
                        'content' => $data['content'],
                        'create_time' => date("Y-m-d H:i:s"),
                        'update_time' => date("Y-m-d H:i:s"),
                    ];
                    if ($data['from_service_id'] == $member['service_id']){
                        continue;
                    }
                    $fd = $member['fd'];
                    if ($fd && $server->exist($fd)) {

                        $server->push($fd, json_encode(['from_username' => $result, 'content' => $content, 'from_service_id' => $data['from_service_id'], 'to_service_id' => $member['service_id'], 'crid'=>$data['crid']]));
                    }
                }

                //新增群聊记录
                Db::table('wolive_chat_room_record')->insert($insertData);
                //所有群成员未读消息+1
                Db::table('wolive_chat_room_member')->where('crid',$data['crid'])->increment('unread_count',1);
            }
        }
    }

    public function onClose($server, int $fd, int $reactorId): void
    {
        var_dump('closed');
    }

    public function onOpen($server, Request $request): void
    {
        $get = $request->get;
        $token = $get['token'];
        //验证token
        $result = $this->validateToken($server, $request->fd, $token);

        if ($result) {
            Db::table('wolive_service')->where('user_name', $result)->update(['fd' => $request->fd]);
        }
    }

    public function validateToken($server, $fd, $token)
    {

        if (!$token) {
            $server->push($fd, json_encode(['type' => 1, 'content' => '请登录']));
            $server->close($fd);

            return false;
        }
        $username = Token::validateToken($token);

        if (!$username) {

            $server->push($fd, json_encode(['type' => 2, 'content' => 'token无效,连接关闭']));
            $server->close($fd);

            return false;
        }

        return $username;
    }
}
