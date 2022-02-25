<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class CustomResponse extends Response
{
    public function sendContent(): static
    {
        $this->run();

        return $this;
    }

    private function run(): void
    {
        $counter = 0;

        while (true) {
            $counter++;
            echo "id: $counter\n";
            echo "event: ping\n";
            echo 'data: {"name": "Hello World"}';
            echo "\n\n";
            ob_flush();
            flush();

            sleep(1);
        }
    }
}
