<?php
class Message extends Controller {
    private $messageModel;

    public function __construct() {
        $this->messageModel = $this->model('MessageModel');
    }
    

    public function fetch($receiver_id) {
        $sender_id = $_SESSION['user_id'];
        $messages = $this->messageModel->getMessages($sender_id, $receiver_id);

        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function send() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sender = $_SESSION['user_id'];
            $receiver = $_POST['receiver_id'];
            $msg = $_POST['message'];

            $this->messageModel->sendMessage($sender, $receiver, $msg);
        }
    }
}
