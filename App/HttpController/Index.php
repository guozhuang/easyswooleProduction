<?php
namespace App\HttpController;
use EasySwoole\Http\AbstractInterface\Controller;
use App\Task\TestTask;
use EasySwoole\EasySwoole\Swoole\Task\TaskManager;

use App\Model\Pool\User;//使用pool的业务封装类,后续分类为相应的数据源

class Index extends Controller
{
	    function index(){
	        //标准入口文件
	        $this->response()->write('hello world');
	    }

	    //测试异步任务的触发，主程序没必要使用异步任务，使用多进程即可
        function templateTask(){
            // 实例化任务模板类 并将数据带进去 可以在任务类$taskData参数拿到数据
            $taskClass = new TestTask('taskData');
            TaskManager::async($taskClass);
            $this->response()->write('执行模板异步任务成功');
        }

        //测试连接池的使用
        function testPool () {
            $obj = new User();
            $result = $obj->getById(1);//使用base的基本方法
            return $this->writeJson(200, 'OK', $result);
        }

        function testWaitGroup() {
            go(function (){
                $ret = [];

                $wait = new \EasySwoole\Component\WaitGroup();

                $wait->add();
                go(function ()use($wait,&$ret){
                    \co::sleep(10);
                    $ret['test1'] = time();
                    $wait->done();
                });

                $wait->add();
                go(function ()use($wait,&$ret){
                    \co::sleep(2);
                    $ret['test2'] = time();
                    $wait->done();
                });

                $wait->wait();

                var_dump($ret);
            });
        }

}
