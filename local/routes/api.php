<?php
use Bitrix\Main\Routing\RoutingConfigurator;
use SP\Tools\Controller\AuthController;
use SP\Tools\Controller\CatalogController;
use \SP\Tools\Controller\TestController;
use \SP\Tools\Controller\SwaggerController;

require_once ($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

return function (RoutingConfigurator $routes) {
	$routes->get('/api', [\BitrixOA\BitrixUiController::class, 'apidocAction']);
	$routes->post('/api/v1/coins', [CatalogController::class, 'coins']);
	$routes->post('/api/v1/auth', [AuthController::class, 'auth']);
};
