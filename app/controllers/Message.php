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
    public function startConversation($otherUserId) {
        $currentUserId = $_SESSION['user_id'];
    
        // Check if conversation already exists
        $conversation = $this->messageModel->getConversationBetween($currentUserId, $otherUserId);
    
        if (!$conversation) {
            // If not, create one
            echo  $currentUserId;
            $conversationId = $this->messageModel->createConversation($currentUserId, $otherUserId);
        } else {
            $conversationId = $conversation->id;
        }
    
        // Redirect to the conversation page
        header("Location: " . ROOT . "/message/userchat/$conversationId");
        exit;
    }
    
    public function chat() {
        $conversations = $this->messageModel->getUserConversations($_SESSION['user_id']);
    
        $this->view('messages/chat', [
            'conversations' => $conversations,
        ]);
    }
    public function userchat($conversationId) {
        $conversation = $this->messageModel->getConversationById($conversationId);
        
    
        if (!$conversation) {
            redirect('pages/notfound');
        }
    
        // Determine who the other user is
        $currentUserId = $_SESSION['user_id'];
        $receiverId = ($conversation->user1_id == $currentUserId) ? $conversation->user2_id : $conversation->user1_id;
        $data = [
            'receiver_id' => $receiverId
        ];
    
        $this->view('messages/userchat', $data);
    }
}
