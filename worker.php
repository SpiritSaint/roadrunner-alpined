<?php
// worker.php

use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

ini_set('display_errors', 'stderr');
include "vendor/autoload.php";
require __DIR__.'/app/vendor/autoload.php';
$app = require_once __DIR__.'/app/bootstrap/app.php';

$relay = new Spiral\Goridge\StreamRelay(STDIN, STDOUT);
$psr7 = new Spiral\RoadRunner\PSR7Client(new Spiral\RoadRunner\Worker($relay));

while ($req = $psr7->acceptRequest()) {
    try {

        $httpFoundationFactory = new HttpFoundationFactory();
        $request = Illuminate\Http\Request::createFromBase($httpFoundationFactory->createRequest($req));

        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

        $response = $kernel->handle(
            $request = $request
        );

        $psr7factory = new PsrHttpFactory();
        $psr7response = $psr7factory->createResponse($response);
        $psr7->respond($psr7response);

        $kernel->terminate($request, $response);
    } catch (\Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}
