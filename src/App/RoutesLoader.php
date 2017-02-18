<?php

namespace App;

use Silex\Application;

class RoutesLoader
{
    private $app;

    /** {@inheritdoc} **/
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->instantiateControllers();
    }

    /** {@inheritdoc} **/
    private function instantiateControllers()
    {
        $this->app['lunch.controller'] = function () {
            return new Controllers\LunchController($this->app['lunch.service'], $this->app['app.serializer']);
        };
    }

    /** {@inheritdoc} **/
    public function bindRoutesToControllers()
    {
        $api = $this->app['controllers_factory'];

        $api->get('/lunch', 'lunch.controller:lunch');

        $this->app->mount('/', $api);
    }
}
