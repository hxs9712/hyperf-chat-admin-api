<?php
namespace HyperfTest\Cases;

use HyperfTest\HttpTestCase;
use App\Service\Dao\ServiceDao;
/**
 * @internal
 * @coversNothing
 */
class ServiceTest extends HttpTestCase
{
    public function testUserDaoFirst()
    {
        $model = \Hyperf\Utils\ApplicationContext::getContainer()->get(ServiceDao::class)->first(21);

        var_dump($model);

        $this->assertSame(21, $model->id);
    }
}
