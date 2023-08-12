<?php
require_once("config.php");
import("includes/class-autoload.inc.php");

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MyChatRoom implements MessageComponentInterface
{
    protected $clients;
    protected $rooms;
    protected $online_users;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->rooms = [];
        $this->online_users = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        // echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg);
        if ($data->type === 'join') {
            $this->joinRoom($from, $data->room);
        } elseif ($data->type === 'message') {
            $this->sendMessage($from, $data->room, $data);
        } elseif ($data->type === 'online') {
            // $this->online_users[$from->resourceId] = $data->user;
            $from->resourceId = $data->user;

            // echo isset($this->online_users[$from->resourceId]) ? $this->online_users[$from->resourceId]['user'] . " connected" : null;
        } 
        echo ($from->resourceId);
    }

    protected function joinRoom(ConnectionInterface $conn, $room)
    {
        $this->rooms[$conn->resourceId] = $room;
        $room = $room;
        // echo isset($this->online_users[$conn->resourceId]) ? $this->online_users[$conn->resourceId]['user'] . " joined $room" : null;
    }

    protected function sendMessage(ConnectionInterface $from, $room, $message)
    {
        foreach ($this->clients as $client) {
            $php = $message->content;
            if (isset($php->sender_id) && $from !== $client) {
                $dt = array(
                    'type' => 'ping',
                    'content' => array(
                        'sender_id' => $php->sender_id,
                        'receiver_id' => $php->receiver_id,
                        'message' => 'You have new message'
                    )
                );
                $client->send(json_encode($dt));
            }
            if (isset($this->rooms[$client->resourceId]) ? $this->rooms[$client->resourceId] : null === $room && $from !== $client) {
                $room_name = $this->rooms[$client->resourceId];
                $rmk = ([$php->sender_id, $php->receiver_id]);
                sort($rmk);
                $room_name_check = implode("connected", $rmk);
                if ($room_name == $room_name_check && $room) {
                    // Send the message to clients in the same room
                    // $php = $message->message;
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
                                $client->send(json_encode($message));
                                return;
                            }
                        }
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
            }
        }
    }
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        unset($this->rooms[$conn->resourceId]);
        $offlineuser = isset($this->online_users[$conn->resourceId]) ? $this->online_users[$conn->resourceId]['user'] : null;
        unset($this->online_users[$conn->resourceId]);
        // echo "Connection {$conn->resourceId} has disconnected\n";
        foreach ($this->clients as $client) {
            $dt = array(
                'type' => 'offline',
                'content' => array(
                    'user' => $offlineuser,
                    'message' => "The user $offlineuser left the chatroom"
                )
            );
            $client->send(json_encode($dt));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        // echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
