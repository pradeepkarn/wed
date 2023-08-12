<?php
require_once("config.php");
import("includes/class-autoload.inc.php");

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


class MyChatP2P implements MessageComponentInterface
{
    protected $clients;
    protected $online_users;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->online_users = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        // echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $msgObj = json_decode($msg);
        // print_r($msgObj);
        $php = $msgObj->content;
        if (isset($msgObj->type) && $msgObj->type == 'online') {
            try {
                if (!array_search($msgObj->user, $this->online_users)) {
                    $this->online_users[$from->resourceId] = $msgObj->user;
                } else {
                    $search_arr = array_flip($this->online_users);
                    unset($this->online_users[$search_arr[$msgObj->user]]);
                    $this->online_users[$from->resourceId] = $msgObj->user;
                }
            } catch (Exception $e) {
            }
        }
        $socketidarr = array_flip($this->online_users);
        foreach ($this->clients as $client) {
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

            if (isset($msgObj->type) && $msgObj->type === 'message' && $this->friendship_exists($obj = $php)) {
                if ($client == $from) {
                    $this->save_msg_in_db($php);
                }

                $to = isset($socketidarr[$php->receiver_id]) ? $socketidarr[$php->receiver_id] : null;
                if ($client->resourceId == $to && $to != null) {
                    $client->send($msg);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        if (isset($this->online_users[$conn->resourceId])) {
            // echo "Connection {$this->online_users[$conn->resourceId]} has disconnected\n";
            unset($this->online_users[$conn->resourceId]);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    function save_msg_in_db($php)
    {
        try {
            $php->created_at = date('Y-m-d H:i:s');
            $db = new Dbobjects;
            $db->tableName = 'chat_history';
            $arr['users'] = json_encode([$php->sender_id, $php->receiver_id]);
            $arr['sender_id'] = $php->sender_id;
            $arr['message'] = $php->message;
            $arr['jsn'] = json_encode($php);
            $db->insertData = $arr;
            return $db->create();
        } catch (\Throwable $th) {
            return false;
        }
    }

    function friendship_exists($obj)
    {
        $db = new Dbobjects;
        $db->tableName = 'chat_history';
        $sql = "select * from requests where (request_by = $obj->sender_id and request_to = $obj->receiver_id) or (request_by = $obj->receiver_id and request_to = $obj->sender_id) and is_accepted = 1;";
        return count($db->show($sql)) == 1 ? true : false;
    }
}
