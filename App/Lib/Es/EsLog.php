<?php
namespace App\Lib\Es;

class EsLog extends EsBase {
	public $index = "loginfo";
	public $type = "detail";
}