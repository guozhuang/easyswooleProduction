<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\EasySwoole;

use App\Lib\Es\EsClient;
use App\Lib\Redis\Redis;
use EasySwoole\Component\Di;
use EasySwoole\EasySwoole\Config;
use EasySwoole\EasySwoole\Crontab\Crontab;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Component\Timer;
use App\Crontab\TaskMinute;
use App\Process\TestProcess;
use EasySwoole\Component\Process\Config as Pconfig;

use App\Lib\Pool\MysqlPool;
use EasySwoole\Component\Pool\PoolManager;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');

        $mysql = Config::getInstance()->getConf('MYSQL');
        PoolManager::getInstance()->register(MysqlPool::class, $mysql['POOL_MAX_NUM']);
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        //$mysql = \Yaconf::get('base.local');
        //切换为连接池，这样就可以将注册的di逻辑隐藏
        /*$mysql = Config::getInstance()->getConf('MYSQL');
        Di::getInstance()->set('MYSQL', \MysqliDb::class, Array(
                'host' => $mysql['host'],
                'username' => $mysql['username'],
                'password' => $mysql['password'],
                'db' => $mysql['db'],
                'port' => $mysql['port'],
                'charset' => $mysql['charset'])
        );*/

        //基础数据的单例注册
        Di::getInstance()->set('ES', EsClient::getInstance());

        Di::getInstance()->set('REDIS', Redis::getInstance());//切换为连接池
        //需要统一配置
        //PoolManager::getInstance()->register(MysqlPool::class,Config::getInstance()->getConf('MYSQL.POOL_MAX_NUM'));
        //使用时，将获取实例封装到对应的lib/redis文件中

        //定时器
        /*$register->add(EventRegister::onWorkerStart, function(\swoole_server $server, $workerId) {
            Timer::getInstance()->loop(1000*2, function() use($workerId) {
                echo $workerId.PHP_EOL;
            });
        });*/

        //定时任务
        //Crontab::getInstance()->addTask(TaskMinute::class);

        //多进程处理
        /*$processConfig = new Pconfig();
        $processConfig->setProcessName('testProcess');
        $processConfig->setArg([
            'arg1'=>time()//实现进程的参数传递
        ]);
        //可以注册多份
        ServerManager::getInstance()->getSwooleServer()->addProcess((new TestProcess($processConfig))->getProcess());*/

        //异步任务  迁移到对应index入口处
        /*$register->add(EventRegister::onWorkerStart, function(\swoole_server $server, $workerId) {
            Timer::getInstance()->loop(1000, function () {
                $taskData = new TestTask();
                TaskManager::async($taskData);
            });
        });*/
        /*Timer::getInstance()->loop(1000, function () {
            TaskManager::async(TestTask::class);
        });*/
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}