<?php
namespace Qnn\logDB;

use DB;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Request;
use Monolog\Logger;

class MysqlHandler
{
	protected $table;
	protected $connection;
	protected $config;
	
	public function __construct(Repository $config,$level = Logger::DEBUG, $bubble = true)
	{
		$this->config = $config;
		$this->table = $this->config['logDB.DB_LOG_TABLE'];
		$this->connection = $this->config['logDB.DB_LOG_CONNECTION'];
	}
	public function write(array $record)
	{
		$data = [
			'host'    => Request::getClientIp(),
			'uri'     => $record['uri'],
			'request_key'=> $record['request_key']??'',
			'params'     => json_encode($record['params'], JSON_UNESCAPED_UNICODE),
			'raw_return'       => $record['raw_return']??'数据异常',
			'create_at'  => date('Y-m-d H:i:s', time()),
		];
		\Illuminate\Support\Facades\DB::connection($this->connection)->table($this->table)->insert($data);
	}
}