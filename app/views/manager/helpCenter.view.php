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
                <h1>12</h1>
                <p>Questions to be answered</p>
            </div>
        </div>

        <?php if (!empty($questions) && (is_array($questions) || is_object($questions))): ?>
    <?php foreach ($questions as $q): ?>
        <div class="question flex-col">
            <h3><?= htmlspecialchars($q->title) ?></h3>
            <p><?= htmlspecialchars($q->description) ?></p>
            
            <form method="POST" action ="<?= ROOT ?>/manager/reply/<?= $q->helpID ?>">
                <textarea name="reply" placeholder="Send a reply" style="<?= !empty($q->reply) ? 'background-color: hsla(116, 76%, 87%, 1);' : '' ?>"><?= htmlspecialchars($q->reply ?? '') ?></textarea>
                <button class="btn btn-accent" type="submit">Reply</button>
            </form>
            
            <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                <?php 
                    $timestamp = $q->createdAt;
                    $date = date('Y-m-d', strtotime($timestamp));
                    $time = date('H:i:s', strtotime($timestamp)); 
                ?>                       
                <p style="font-size : 11px;">Asked on <?= $date ?> at <?= $time ?></p>
            </div>
        </div>
        <br>
    <?php endforeach; ?>
<?php else: ?>
    <p>All good here!</p>
<?php endif; ?>


        

        
    </div>

</div>




<?php require APPROOT . '/views/inc/footer.php'; ?>