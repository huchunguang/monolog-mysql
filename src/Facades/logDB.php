<?php
namespace Qnn\logDB\Facades;
use Illuminate\Support\Facades\Facade;
class logDB extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'ApiLog';
	}
}