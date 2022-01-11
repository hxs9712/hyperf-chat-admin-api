<?php
namespace App\Controller;

use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Contract\RequestInterface;

class SystemController extends AbstractController{
    /**
     * 对话列表类.
     *
     * @return mixed
     */
    public function getchats(RequestInterface $request)
    {
        $login = ['service_id'=>30,'business_id'=>1];

        $get = $request->all();
        $sort = isset($get['sort']) && $get['sort'] == 2 ? $get['sort'] : 1;
        $query = Db::table('wolive_queue');
//        if ($login['level'] != 'super_manager') {
//            $query = $query->where('service_id', $login['service_id']);
//        }
        $query = $query->where('service_id', $login['service_id']);
        $visiters = $query->distinct()
            ->select('visiter_id','timestamp')
            ->where('business_id', $login['business_id'])
            ->where('state', 'underway')
            ->orderBy('timestamp','desc')
            ->get();  // underway 查询当前有效会话状态
        $visiters = $visiters->toArray();
        //echo "<pre>";print_r($visiters);echo "<pre>"; exit;
        if (empty($visiters)) {
            $data = ['code' => 1, 'msg' => '暂时没有数据！'];
            return $data;
        } else {
            $visiters = array_column($visiters, 'visiter_id');
        }


        $chatonlinearr = [];
        $chatonlineunread = [];
        $chatofflinearr = [];
        $chatofflineunread = [];

        //wolive_visiter 访客表
        $data = Db::table('wolive_visiter')->where('business_id' , $login['business_id'])->whereIn('visiter_id',$visiters)->get()->toArray();
        //wolive_chats 消息表
        $chatids= Db::table('wolive_chats')->select(Db::raw('max(cid) as cid'))
            ->where('business_id', $login['business_id'])
            ->where('visiter_id', 'in', $visiters)
            ->where('service_id', $login['service_id'])
            ->groupBy(['visiter_id'])
            ->get();

        $chatids = $chatids->toArray();
        $cids = array_column($chatids, 'cid');

        if (empty($cids)) {
            $chatsList = [];
        } else {
            $chats = Db::table('wolive_chats')->where('cid', 'in', $cids)
                ->get();
            $chats = $chats->toArray();
            $chatsList = array_column($chats, null, 'visiter_id');
        }


        $result = Db::table('wolive_chats')->where('business_id', $login['business_id'])
            ->select('visiter_id',Db::raw('count(visiter_id) as count'))
            ->where('state', 'unread')
            ->where('direction', 'to_service')
            ->groupBy(['visiter_id'])
            ->get();
        $result = $result->toArray();
        $resultList = array_column($result, null, 'visiter_id');
        foreach ($data as $v) {
            $chats2['content'] = isset($chatsList[$v['visiter_id']]['content']) ? $chatsList[$v['visiter_id']]['content'] : '';
            $chats2['timestamp'] = isset($chatsList[$v['visiter_id']]['timestamp']) ? $chatsList[$v['visiter_id']]['timestamp'] : 0;

            $values = preg_match_all('/<img.*\>/isU', $chats2['content'], $out);
            if ($values) {

                $img = $out[0];

                if ($img) {

                    $chats = "";
                    foreach ($img as $value) {
                        $attr = $this->extract_attrib($value);

                        if ($attr) {
                            $src = $attr["src"];
                            if ($src) {
                                if (strpos($src, "emo_")) {
                                    $newimg = "<img src={$src}>";
                                } else {
                                    $newimg = "[图片]";
                                }
                            }
                        } else {
                            $newimg = '[图片]';
                        }
                        $chats .= $newimg;
                    }
                }
                $newstr = preg_replace('/<img.*\>/isU', "", $chats2['content']);
                $newcontent = $chats . $newstr;
            } else {

                if (strpos($chats2['content'], '</i>') !== false) {

                    $newcontent = '[文件]';
                } elseif (strpos($chats2['content'], '</audio>') !== false) {

                    $newcontent = '[音频]';
                } elseif (strpos($chats2['content'], '</a>') !== false) {
                    $newcontent = '[超链接]';
                } else {

                    if ($chats2['content'] == null) {
                        $newcontent = '';
                    } else {
                        $newcontent = $chats2['content'];
                    }
                }
            }
            $v['content'] = strip_tags($newcontent);
            if (isset($resultList[$v['visiter_id']]['count'])) {
                $v['count'] = $resultList[$v['visiter_id']]['count'];
            } else {
                $v['count'] = 0;
            }

            if (!empty($chats2['timestamp'])) {
                $time = $chats2['timestamp'];
                $v['order'] = $chats2['timestamp'];
            } else {
                $time = strtotime($v['timestamp']);
                $v['order'] = 0;
            }
            $v['timestamp'] = $this->formatTime($time);
            $url = 'http://hyperf.com/mobile/admin/talk';
            $v['mobile_route_url'] = $url . "?channel=" . $v['channel'] . "&avatar=" . urlencode($v['avatar']) . "&visiter_id=" . $v['visiter_id'];
            if ($v['count'] > 0) {
                if ($v['state'] == 'online') {
                    $v['sort'] = 50;
                    $chatonlineunread[] = $v;
                } else {
                    $v['sort'] = 30;
                    $chatofflineunread[] = $v;
                }
            } else {
                if ($v['state'] == 'online') {
                    $v['sort'] = 20;
                    $chatonlinearr[] = $v;
                } else {
                    $v['sort'] = 10;
                    $chatofflinearr[] = $v;
                }
            }
        }

        if ($sort==1){
            $chatarr = array_merge($chatonlineunread, $chatofflineunread, $chatonlinearr, $chatofflinearr);
            array_multisort(array_column($chatarr, 'istop'), SORT_DESC, array_column($chatarr, 'sort'), SORT_DESC, array_column($chatarr, 'order'), SORT_DESC, array_column($chatarr, 'vid'), SORT_DESC, $chatarr);
        }else{
            $chatarr = array_merge($chatofflinearr, $chatonlinearr, $chatofflineunread, $chatonlineunread);
            array_multisort(array_column($chatarr, 'istop'), SORT_ASC, array_column($chatarr, 'sort'), SORT_ASC, array_column($chatarr, 'order'), SORT_ASC, array_column($chatarr, 'vid'), SORT_ASC, $chatarr);
        }

        $result = Db::table('wolive_chats')->where('service_id', $login['service_id'])->where('business_id', $login['business_id'])->where('state', 'unread')->where('direction', 'to_service')->count();
        if ($chatarr) {
            // 接待中人数
            $recep_num = count($chatarr);
            $data = [
                'code' => 0,
                'data' => $chatarr,
                'all_unread_count' => $result,
                'recep_num' => $recep_num,
            ];
            return $data;
        } else {
            $data = ['code' => 1, 'msg' => '暂时没有数据！'];
            return $data;
        }
    }

    function extract_attrib($tag)
    {
        preg_match_all('/(id|alt|title|src)=("[^"]*")/i', $tag, $matches);
        $ret = array();
        foreach ($matches[1] as $i => $v) {
            $ret[$v] = $matches[2][$i];
        }
        return $ret;
    }

    function opencs(){
        $visiter_id = $this->request->post('visiter_id');
        Db::table('wolive_queue')
            ->where('visiter_id', $visiter_id)
            ->where('business_id', 1)
            ->where('service_id', 30)
            ->update(['state' => 'normal']);
        return['code' => 0, 'msg' => 'success'];
    }
}