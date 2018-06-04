<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $data) {
        $num_of_clients = count($this->clients);
        $data = json_decode($data);
        $type = $data->type;

        switch ($type) {
            case 'open':
                $user_id = $data->user_id;
				$chat_msg = "";
                
                $from->send(json_encode(array("type"=>$type,"msg"=>$chat_msg, "user_id"=>$user_id, "is_it_me"=>true)));
				foreach($this->clients as $client){
					if($from !== $client)
						$client->send(json_encode(array("type"=>$type,"msg"=>$chat_msg, "user_id"=>$user_id, "is_it_me"=>false)));
                }
                break;
            case 'chat':
				$user_id = $data->user_id;
				$chat_msg = $data->chat_msg;
				
				$from->send(json_encode(array("type"=>$type,"msg"=>$chat_msg, "user_id"=>$user_id, "is_it_me"=>true)));
				foreach($this->clients as $client){
					if($from !== $client)
						$client->send(json_encode(array("type"=>$type,"msg"=>$chat_msg, "user_id"=>$user_id, "is_it_me"=>false)));
                }
				break;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        // unset($this->users[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
