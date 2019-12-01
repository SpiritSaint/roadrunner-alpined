<?php
// worker.php

include "vendor/autoload.php";
require __DIR__.'/app/vendor/autoload.php';

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

ini_set('display_errors', 'stderr');

$app = require_once __DIR__.'/app/bootstrap/app.php';

$relay = new Spiral\Goridge\StreamRelay(STDIN, STDOUT);
$psr7 = new Spiral\RoadRunner\PSR7Client(new Spiral\RoadRunner\Worker($relay));

while ($req = $psr7->acceptRequest()) {
    try {

        // Create HttpFoundation Factory
        $httpFoundationFactory = new HttpFoundationFactory();

        // Create Request Object using Psr7 Request as base
        $request = Illuminate\Http\Request::createFromBase($httpFoundationFactory->createRequest($req));

        // Make Http Kernel Object
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

        // Handle Http Request
        $response = $kernel->handle(
            $request = $request
        );


        // Create Psr7 Http Factory
        $psr7factory = new PsrHttpFactory();

        // Create Psr7 Response from Laravel Response
        $psr7response = $psr7factory->createResponse($response);

        // Respond the Request as a Psr7 Respond
        $psr7->respond($psr7response);

        // Send Terminate Signal to Kernel
        $kernel->terminate($request, $response);
    } catch (\Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}
