<?php
namespace App\HttpController;
use App\Lib\Es\EsLog;
use App\Lib\Redis\Redis;
use EasySwoole\Http\AbstractInterface\Controller;

class EsApi extends Controller
{
	    function index(){
	        //标准入口文件
	        $this->response()->write('hello world');
	    }

    public function getEsData() {
        $params = $this->request()->getRequestParam();
        $key = $params['key'];
        $value = $params['value'];
        $result = (new EsLog())->searchByKey($key, $value);
        return $this->writeJson(200, "OK", $result);
    }

    public function saveLog() {
        //测试保存的数据，
        //扫描静态文件，转换为标准的es数据
        //todo:修改相应适配的字段，直接从post的数据里读取值，对读取的值标准化处理
        //todo:例如id排序，所以需要一个redis的自增id作为id值
        //todo:还需要对其他字段的适配
        $filePath = 'assets/static/output.log';
        $data = file($filePath);
        $saveData = array();
        foreach ($data as $key => $value) {
            //表转化es对应数据
            $tmpData = explode('|', $value);
            //进行字符串标准化
            foreach ($tmpData as $v) {
                if (strpos($v, '#')) {
                    $tmp = explode('#', $v);
                    $saveData[$key][$tmp[0]] = trim($tmp[1]);
                }
            }
        }
        $esObj = new EsLog();
        foreach ($saveData as $value) {
            $esObj->saveIndex($value);
        }
    }

    //提供一个公共的保存逻辑:写入本地的redis机器的stream内，标准化入库，只是测试了相应的模板可用
    //todo:修改相应适配的字段，直接从post的数据里读取值，对读取的值标准化处理
    //todo:例如id排序，所以需要一个redis的自增id作为id值
    //todo:还需要对其他字段的适配
    //todo:将es测试联调到130和154上面
    public function saveLogInfo() {
        $data = $this->request()->getRequestParam();//测试正常
        if (!empty($data)) {
            $logData = array();
            foreach ($data as $key => $value) {
                $logData[trim($key)] = trim($value);
            }
            $logData['id'] = Redis::getInstance()->incr('loginfo_id');

            Redis::getInstance()->xAdd($logData);
        }

        return $this->writeJson(200, "OK");
    }

    public function getData() {
	        $data = Redis::getInstance()->xReadGroup(0);
	        var_dump($data);
    }

    public function batchSave() {
        $esObj = new EsLog();
        $esObj->batchSaveLog();
    }

}
