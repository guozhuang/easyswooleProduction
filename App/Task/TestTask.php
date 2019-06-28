<?php
namespace App\Task;
use \EasySwoole\EasySwoole\Swoole\Task\AbstractAsyncTask;

class TestTask extends AbstractAsyncTask
{

    function run($taskData, $taskId, $fromWorkerId,$flags = null)
    {
        // 需要注意的是task编号并不是绝对唯一
        // 每个worker进程的编号都是从0开始
        // 所以 $fromWorkerId + $taskId 才是绝对唯一的编号
        // !!! 任务完成需要 return 结果
        var_dump($taskData);
        echo $taskId.'-'.$fromWorkerId.PHP_EOL;
        //通过taskid和workid来确定单个进程的单个任务的匹配逻辑
        return true;
    }

    /**
     * 任务执行完的回调
     * @param mixed $result  任务执行完成返回的结果
     * @param int   $task_id 执行任务的task编号
     */
    function finish($result, $task_id)
    {
        // 任务执行完的处理
    }
}