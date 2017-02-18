<?php

$app['log.level'] = Monolog\Logger::ERROR;
$app['api.version'] = 'v1';
$app['api.endpoint'] = '/api';

$app['data.path'] = dirname(__FILE__).'/../../src/App/Data';
$app['data.recipes'] = $app['data.path'].'/recepies.json';
$app['data.ingredients'] = $app['data.path'].'/ingredients.json';
