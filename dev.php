<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2019-01-01
 * Time: 20:06
 */

return [
    'SERVER_NAME' => "EasySwoole",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9501,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 8,
            'task_worker_num' => 8,
            'reload_async' => true,
            'task_enable_coroutine' => true,
            'max_wait_time'=>3
        ],
    ],
    'TEMP_DIR' => null,
    'LOG_DIR' => null,
    'PHAR' => [
        'EXCLUDE' => ['.idea', 'Log', 'Temp', 'easyswoole', 'easyswoole.install']
    ],
    'MYSQL' => [
        'host'=>"192.168.99.100",
        'user' => "root",
        'password' => "123456",
        'database'=>"earch",
        'port' => '3306',
        'charset' =>"utf8",
        'is_zk'   => false,//是否使用名字服务
        'POOL_MAX_NUM' => 8,
        'POOL_TIME_OUT' => 0.1
    ],
    'ES' => [
        'host' => '192.168.99.100',
        'port' => 9200,
        'is_zk'   => false//是否使用名字服务
    ],
    'REDIS' => [
        'host' => '192.168.99.100',
        'port' => 6379,
        'time_out' => 3,
        'is_zk'   => false//是否使用名字服务
    ]
];
