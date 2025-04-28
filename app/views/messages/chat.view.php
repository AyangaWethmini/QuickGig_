<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2,3]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/messages/chat.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">


<body>

    <div class="wrapper">

        <?php
            if($_SESSION['user_role'] == 2){
                if ($_SESSION['current_role'] == 1) {
                    require APPROOT . '/views/jobProvider/jobProvider_sidebar.php';
                }else if ($_SESSION['current_role'] == 2) {
                    require APPROOT . '/views/seeker/seeker_sidebar.php';
                }
            }else if($_SESSION['user_role'] == 3){
                require APPROOT . '/views/jobProvider/organization_sidebar.php';
            }
        ?>
       <div class="error-msg-tika">
       <?php if (empty($data['conversations'])): ?>
            <div class="no-messages-container">
                <img src="<?= ROOT ?>/assets/images/no-messages.png" alt="No Messages" class="no-messages-icon">
                <p>No messages or chats yet!</p>
            </div>
        <?php else: ?>
            <div class="conversations-list">
                <h3 class="header">Your Chats</h3>
                <ul class="list">
                    <?php foreach ($data['conversations'] as $conv): ?>
                        <li class="list-item">
                            <a  href="<?= ROOT ?>/message/userchat/<?= $conv->id ?>">
                                <img class="profileimage" src="<?= !empty($conv->other_user_profile) ? 'data:image/jpeg;base64,' . base64_encode($conv->other_user_profile) : ROOT . '/assets/images/default.jpg' ?>" alt="" class="profile-pic">
                                <span><?= htmlspecialchars($conv->other_user_name) ?></span>
                                
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

       </div>
        



    </div>



</body>