<?php


use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\SocketServer;
use React\EventLoop\Loop;
use App\Sockets\ChatSocket;

require dirname(__DIR__) . '/vendor/autoload.php';

$loop = Loop::get();

$chatLogic = new ChatSocket();


$factory = new Clue\React\Redis\Factory($loop);

$redis = $factory->createLazyClient('redis://127.0.0.1:6379');

echo "Đang kết nối Redis...\n";

$redis->subscribe('chat_channel');

$redis->on('message', function ($channel, $payload) use ($chatLogic) {
    $chatLogic->onRedisMessage($payload);
});


$webSock = new SocketServer('0.0.0.0:8080', [], $loop);

$server = new IoServer(
    new HttpServer(
        new WsServer(
            $chatLogic
        )
    ),
    $webSock,
    $loop // 
);

echo "WebSocket Server đang chạy tại cổng 8080...\n";

$server->run();