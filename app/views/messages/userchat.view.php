<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/messages/userchat.css">

<body>

    <div class="wrapper">

        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
        <div class="inner-wrapper">
            <div class="chat-header">
                <button onclick="history.back()" class="back-btn">← Back</button>
                <div class="chat-header-content">
                    <div class="image">
                        <?php if ($data['pp']): ?>
                            <?php
                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                            $mimeType = $finfo->buffer($data['pp']);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($data['pp']) ?>" alt="Profile Picture">
                        <?php else: ?>
                            <img src="<?= ROOT ?>/assets/images/default.jpg" alt="No image available">
                        <?php endif; ?>
                    </div>
                    <span class="username"><?= $data['username'] ?></span>
                </div>
            </div>


            <div id="chat-box"></div>
            <form id="send-message-form">
    <input type="hidden" id="receiver_id" value="<?= $data['receiver_id'] ?>">
    
    <textarea id="message" placeholder="Type your message..."></textarea>
    <button type="submit" id="send-btn" disabled>Send</button>
</form>

        </div>

    </div>

    <script>
        let receiver_id = document.getElementById('receiver_id').value;

        function fetchMessages() {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "<?= ROOT ?>/message/fetch/" + receiver_id, true);
            xhr.onload = function() {
                if (this.status == 200) {
                    let messages = JSON.parse(this.responseText);
                    let chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';
                    messages.forEach(function(msg) {
                        let whoClass = (msg.sender_id == <?php echo json_encode($_SESSION['user_id']); ?>) ? 'you' : 'them';
                        let messageElement = document.createElement('div');
                        messageElement.className = `message ${whoClass}`;
                        messageElement.textContent = msg.message;
                        chatBox.appendChild(messageElement);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            }
            xhr.send();
        }


        setInterval(fetchMessages, 2000);

        // Send Message via AJAX
        document.getElementById('send-message-form').onsubmit = function(e) {
            e.preventDefault();
            let message = document.getElementById('message').value;
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT ?>/message/send", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                document.getElementById('message').value = '';
                fetchMessages();
            }
            xhr.send("receiver_id=" + receiver_id + "&message=" + encodeURIComponent(message));
        }
        const messageInput = document.getElementById('message');
    const sendBtn = document.getElementById('send-btn');

    messageInput.addEventListener('input', () => {
        const hasText = messageInput.value.trim().length > 0;
        sendBtn.disabled = !hasText;
    });
    </script>


</body>