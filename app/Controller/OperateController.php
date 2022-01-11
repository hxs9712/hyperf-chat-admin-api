<?php

namespace App\Controller;

use App\Pool\TestPool;
use App\Service\QueueService;
use Hyperf\DbConnection\Db;
use Hyperf\DbConnection\Pool\DbPool;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Pool\Channel;
use Hyperf\Pool\SimplePool\PoolFactory;
use Hyperf\Redis\Redis;
use Hyperf\Utils\Coroutine;
use Psr\Container\ContainerInterface;
use Swoole\Exception;
use function PHPUnit\Framework\throwException;

class OperateController extends AbstractController
{
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;


    public function getrecordlist(RequestInterface $request, ResponseInterface $response)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $query = Db::table('wolive_operate_record')->leftJoin('wolive_service', 'wolive_operate_record.service_id', '=', 'wolive_service.service_id');

        $result = $query->orderBy('create_date', 'desc')->offset($page)->limit($limit)->get()->toArray();
        $count = Db::table('wolive_operate_record')->count();
        $page = [
            'total' => $count,
            'per_page' => $limit,
            'current_page' => $page,
            'last_page' => ceil($count / $limit)
        ];

        return $this->result(200, '操作成功', $result, $page);
    }

    public function testPool()
    {
        $TestPool = TestPool::getInstance($this->container, 'default');
        try {

            $connection = $TestPool->get();

            $client = $connection->getConnection(); // 即上述 Client.
            $res = $client->table('wolive_visiter')->limit(10)->get();
            $connection->release();

            return ['res_count' => count($res)];
        } catch (Exception $exception) {
            throwException($exception);
        }


    }
}