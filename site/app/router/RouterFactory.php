<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

		$metadata = array(
			'presenter' => 'Homepage',
			'action' => 'default',
			'param' => [Route::FILTER_IN => 'urldecode', Route::FILTER_OUT => 'urlencode'],
		);

		$router[] = new Route('[<param>]', $metadata, Route::SECURED);
		return $router;
	}

}
