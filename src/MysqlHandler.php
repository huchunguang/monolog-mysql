<?php
namespace Qnn\logDB;

use DB;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Illuminate\Config\Repository;
class MysqlHandler 
{
	protected $table;
	protected $connection;
	protected $config;
	
	public function __construct(Repository $config,$level = Logger::DEBUG, $bubble = true)
	{
		$this->config=$config;
		$this->table      = $this->config('monologDB.DB_LOG_TABLE');
		$this->connection = $this->config('monologDB.DB_LOG_CONNECTION');
		parent::__construct($level, $bubble);
	}
	protected function write(array $record)
	{
		$data = [
			'host'    => gethostname(),
			'uri'     => $record['uri'],
			'params'     => json_encode($record['params'], JSON_UNESCAPED_UNICODE),
			'raw_return'       => $record['raw_return']??'数据异常',
			'created_at'  => $record['datetime'],
		];
		\Illuminate\Support\Facades\DB::connection($this->connection)->table($this->table)->insert($data);
	}
}