<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;

define('ROOT_PATH', __DIR__.'/..');
//accepting JSON
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new ServiceControllerServiceProvider());

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => ROOT_PATH.'/storage/logs/'.Carbon::now('Europe/London')->format('Y-m-d').'.log',
    'monolog.level' => $app['log.level'],
    'monolog.name' => 'application',
));

//load services
$servicesLoader = new App\ServicesLoader($app);
$servicesLoader->bindServicesIntoContainer();

//load routes
$routesLoader = new App\RoutesLoader($app);
$routesLoader->bindRoutesToControllers();

$app->error(function (\Exception $e, $code) use ($app) {
    $app['monolog']->addError($e->getMessage());
    $app['monolog']->addError($e->getTraceAsString());

    return new JsonResponse(array('statusCode' => $code, 'message' => $e->getMessage(), 'stacktrace' => $e->getTraceAsString()));
});

return $app;
