<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class StreamController
{
    #[Route(path: '/api/stream-v1', methods: ['GET'])]
    public function v1(): Response
    {
        $output = fopen('php://stdout', 'w');

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

    #[Route(path: '/api/stream-v2', methods: ['GET'])]
    public function v2(): Response
    {
        $response = new StreamedResponse(function () {
            echo 'Hello World';
            ob_flush();
            flush();
            sleep(5);
            echo 'Hello World';
            ob_flush();
            flush();
        });
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-store');
        $response->headers->set('Content-Type', 'text/event-stream');

        return $response;
    }
}
