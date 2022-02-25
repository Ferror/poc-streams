<?php
//Working example

date_default_timezone_set("America/New_York");
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");
header('Access-Control-Allow-Origin: http://localhost:63342');
header('Access-Control-Allow-Methods: GET, OPTIONS');

$counter = random_int(1, 10);
while (true) {
    // Every second, send a "ping" event.

    echo "event: ping\n";
    $curDate = date(DATE_ATOM);
    echo 'data: {"time": "' . $curDate . '"}';
    echo "\n\n";

    // Send a simple message at random intervals.

    $counter--;

    if (!$counter) {
        echo 'data: This is a message at time ' . $curDate . "\n\n";
        $counter = random_int(1, 10);
    }

//    ob_end_flush();
    ob_flush();
    flush();

    // Break the loop if the client aborted the connection (closed the page)

    if ( connection_aborted() ) break;

    sleep(1);
}
