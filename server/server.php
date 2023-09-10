<?php
if (!defined("direct_access")) {
    define("direct_access", 1);
}
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/../settings.php");
import("/includes/class-autoload.inc.php");
require_once 'vendor/autoload.php';

try {
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new MyChatP2P()
            )
        ),
        WS_PORT
    );

    $server->run();
} catch (Exception $e) {
    // Handle the exception as needed, you can log it or perform other actions
    // but don't let it stop the server from running
    // echo "An error occurred: " . $e->getMessage();
}
