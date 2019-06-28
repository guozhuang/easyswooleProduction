<?php
namespace App\Lib\Es;
use EasySwoole\Component\Di;
class EsBase {
	public $esClient = null;
	public function __construct() {
		$this->esClient = Di::getInstance()->get("ES");
	}

    /**
     * @param $key
     * @param $value
     * @param int $from
     * @param int $size
     * @param string $type
     * @return array
     */
    public function searchByKey($key, $value, $from =0, $size = 10, $type = "match") {
        $key = trim($key);
        $value = trim($value);
        if(empty($key)) {
            return [];
        }
        $params = [
            "index" => $this->index,
            "type" => $this->type,
            'body' => [
                'query' => [
                    $type => [
                        $key => $value
                    ],
                ],
                'from' => $from,
                'size' => $size
            ],
        ];
        $result = $this->esClient->search($params);
        return $result;

    }

    //索引数据
    public function saveIndex($data) {
        //每个data处理时需要trrim
        $params = [
            "index" => $this->index,
            "type" => $this->type,
            'body' => $data
        ];

        $response = $this->esClient->index($params);
        print_r($response);
    }

    //todo:批量索引数据
    public function batchSaveLog($data=array()) {
        //对数据的批量格式化
        if (!empty($data)) {
            foreach ($data as $value) {
                $params['body'][]=array(
                    'index' => array(
                        '_index'=> $this->index,
                        '_type'=>  $this->type
                    ),
                );

                //再构造详细数据
                $params['body'][] = $value;
            }

            $res = $this->esClient->bulk($params);
            var_dump($res);
        }

        /*for($i = 41; $i <= 50; $i ++) {
            $params['body'][]=array(
                'index' => array(
                    '_index'=> $this->index,
                    '_type'=>  $this->type
                ),
            );

            $params['body'][]=array(
                'aa'=>$i
            );
        }*/
    }

}