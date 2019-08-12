<?php
namespace Qnn\logDB;

use Illuminate\Support\ServiceProvider;


class LogDBProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// 发布配置文件
		$this->publishes([
			__DIR__.'/config/logDB.php' => config_path('logDB.php'),
		]);
	}
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('ApiLog', function ($app) {
			return new MysqlHandler($app['config']);
		});
	}
	
	
	
}