<?php
require_once("config.php");
import("includes/class-autoload.inc.php");

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MyChat implements MessageComponentInterface
{
    protected $clients;
    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New client connected: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {

            $php = json_decode($msg);
            try {
                $db = new Dbobjects;
                $db->tableName = 'chat_history';
                $sql = "select * from requests where (request_by = $php->sender_id and request_to = $php->receiver_id) or (request_by = $php->receiver_id and request_to = $php->sender_id) and is_accepted = 1;";
                $friendship_exist = count($db->show($sql)) == 1 ? true : false;
                $php->created_at = date('Y-m-d H:i:s');
                if ($friendship_exist === true) {
                    $arr['users'] = json_encode([$php->sender_id, $php->receiver_id]);
                    $arr['sender_id'] = $php->sender_id;
                    $arr['message'] = $php->message;
                    $arr['jsn'] = json_encode($php);
                    $db->insertData = $arr;
                    $db->create();
                    if ($client !== $from) {
                        $client->send($msg);
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Client disconnected: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
