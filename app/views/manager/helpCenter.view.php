<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/helpCenter.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row">
<?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    <div class="main-content container flex-col" style="margin-left: 300px;">
        <div class="header container flex-row">
            <h3>Help Center</h3>
        </div>
        <hr>
        <div class="help-overview container flex-col">
            <div class="card flex-row">
                <h1><?= count(array_filter($questions, fn($q) => is_null($q->reply))) ?></h1>
                <p>Questions to be answered</p>
            </div>
        <div class="tabs">
            <button class="tab-button active" data-tab="unanswered" onclick="showTab(this)">Unanswered</button>
            <button class="tab-button" data-tab="answered" onclick="showTab(this)">Answered</button>
        </div>

        <div id="unanswered" class="tab-content active">
            <?php if (!empty($questions) && (is_array($questions) || is_object($questions))): ?>
                <?php foreach ($questions as $q): ?>
                    <?php if (is_null($q->reply)): ?>
                        <div class="question flex-col">
                            <h3><?= htmlspecialchars($q->title) ?></h3>
                            <p><?= htmlspecialchars($q->description) ?></p>
                            
                            <form method="POST" action ="<?= ROOT ?>/manager/reply/<?= $q->helpID ?>">
                                <textarea name="reply" placeholder="Send a reply" required></textarea>
                                <button class="btn btn-accent" type="submit">Reply</button>
                            </form>
                            
                            <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                                <?php 
                                    $timestamp = $q->createdAt;
                                    $date = date('Y-m-d', strtotime($timestamp));
                                    $time = date('H:i:s', strtotime($timestamp)); 
                                ?>                       
                                <p style="font-size : 13px;">Asked on <?= $date ?> at <?= $time ?></p>
                            </div>
                        </div>
                        <br>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No unanswered questions!</p>
            <?php endif; ?>
        </div>

        <div id="answered" class="tab-content">
            <?php if (!empty($questions) && (is_array($questions) || is_object($questions))): ?>
            <?php foreach ($questions as $q): ?>
            <?php if (!is_null($q->reply)): ?>
            <div class="question flex-col">
                <h3><?= htmlspecialchars($q->title) ?></h3>
                <p><?= htmlspecialchars($q->description) ?></p>
                
                <form method="POST" action="<?= ROOT ?>/manager/reply/<?= $q->helpID ?>" style="margin-top: 10px;">
                <textarea name="reply" style="background-color: hsla(116, 76%, 87%, 1);" required><?= htmlspecialchars($q->reply) ?></textarea>
                <button class="btn btn-accent" type="submit">Update Reply</button>
                </form>
                
                <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                <?php 
                $timestamp = $q->createdAt;
                $date = date('Y-m-d', strtotime($timestamp));
                $time = date('H:i:s', strtotime($timestamp)); 
                ?>                       
                <p style="font-size : 13px;">Asked on <?= $date ?> at <?= $time ?></p>
                </div>
            </div>
            <br>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No answered questions!</p>
            <?php endif; ?>
        </div>
        </div>

    <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            if (isset($_SESSION['success'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>

</div>



<script>
function showTab(button) {
    const tabId = button.getAttribute('data-tab');
    const tabs = document.querySelectorAll('.tab-content');
    const buttons = document.querySelectorAll('.tab-button');

    tabs.forEach(tab => tab.classList.remove('active'));
    buttons.forEach(btn => btn.classList.remove('active'));

    document.querySelector(`#${tabId}`).classList.add('active');
    button.classList.add('active');
}

            </script>



<?php require APPROOT . '/views/inc/footer.php'; ?>