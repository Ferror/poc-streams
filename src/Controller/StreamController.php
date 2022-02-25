<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class StreamController
{
    #[Route(path: '/ping', methods: ['GET', 'OPTIONS'])]
    public function index(): Response
    {
        $response = new Response('', 204);

        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:63342');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

        return $response;
    }

    /**
     * Does not work.
     */
    #[Route(path: '/api/v1/stream', methods: ['GET'])]
    public function v1(): Response
    {
        $output = fopen('php://stdout', 'wb');
        $response = new StreamedResponse(function() use ($output) {
            for($i = 0; $i <= 5; $i++) {
                fwrite($output, $i . "\n");
                echo $i . "\n";
                sleep(2);
            }
        });
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Content-Type', 'text/event-stream');

        return $response;
    }

    #[Route(path: '/api/v2/stream', methods: ['GET', 'OPTIONS'])]
    public function v2(): Response
    {
        $response = new StreamedResponse(
            function () {
                for ($i = 0; $i < 10; $i++) {
                    echo "id: $i\n";
                    echo "event: ping\n";
                    echo 'data: {"name": "Hello World"}';
                    echo "\n\n";
                    ob_flush();
                    flush();
                }
            },
            200
        );
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-store');
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:63342');
        $response->headers->set('Access-Control-Allow-Headers', 'Cache-Control, X-Requested-With, Content-Type, Accept, Origin, Authorization');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');

        return $response;
    }
}
