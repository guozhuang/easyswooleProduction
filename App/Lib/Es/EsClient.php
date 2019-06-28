<?php
namespace App\Lib\Es;
use EasySwoole\Component\Singleton;
use EasySwoole\EasySwoole\Config;
use Elasticsearch\ClientBuilder;

class EsClient {
	use Singleton;
	public $esClient = null;
	private function __construct() {
		//$config = \Yaconf::get("es.dev");
        $config =  Config::getInstance()->getConf('ES');
		try {
			$this->esClient = ClientBuilder::create()->setHosts([$config['host'] . ":" . $config['port']])->build();
		}catch(\Exception $e) {
			// todo:新增对应的异常日志管理
		}

		if(empty($this->esClient)) {
			// todo：也对连接问题加异常管理
		}
	}

	/**
	 * @auth   singwa
	 * @param  [type] $name      [description]
	 * @param  [type] $arguments [description]
	 * @return [type]            [description]
	 */
	public function __call($name, $arguments) {
		
		///var_dump(...$arguments);
		return $this->esClient->$name(...$arguments);
	}
}