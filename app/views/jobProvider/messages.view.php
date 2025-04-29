<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/messages.css">

<body>

    <div class="wrapper flex-row">

        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>

        <div class="no-messages-container">
            <img src="<?= ROOT ?>/assets/images/no-messages.png" alt="No Messages" class="no-messages-icon">
            <div class="chat-box" id="chat-box"></div>

            <form id="send-message-form">
                <input type="" id="receiver_id" value="ACC67a1e3e82b2ee4.18">
                <textarea id="message"></textarea>
                <button type="submit">Send</button>
            </form>

        </div>

    </div>

    <script>
        let receiver_id = document.getElementById('receiver_id').value;
        console.log(receiver_id);
        function fetchMessages() {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "<?=ROOT?>/message/fetch/ACC67a1e3e82b2ee4.18", true);
            xhr.onload = function() {
                if (this.status == 200) {
                    let messages = JSON.parse(this.responseText);
                    let chatBox = document.getElementById('chat-box');
                    console.log(messages);
                    chatBox.innerHTML = '';
                    messages.forEach(function(msg) {
                        let who = (msg.sender_id == <?php echo json_encode($_SESSION['user_id']); ?>) ? 'You' : 'Them';

                        chatBox.innerHTML += `<p><strong>${who}:</strong> ${msg.message}</p>`;
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
            xhr.open("POST", "<?=ROOT?>/message/send", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                document.getElementById('message').value = '';
                fetchMessages();
            }
            xhr.send("receiver_id=" + receiver_id + "&message=" + encodeURIComponent(message));
        }
    </script>

</body>