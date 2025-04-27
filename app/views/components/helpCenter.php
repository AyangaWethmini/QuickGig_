<link rel="stylesheet" href="<?=ROOT?>/assets/css/help.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="flex-row">
    <div class="main-content container flex-row">
        <div class="flex-col">

        <?php
            $currentController = explode('/', $_GET['url'])[0] ?? 'JobSeeker';
        ?>

            <div class="header container flex-row">
                <h3>Help Center</h3><br>
            </div>

            <hr><br>

            <div class="help-dashboard flex-row">
                <div class="suggestions">
                    <h4>FAQ</h4><br>
                    <ul class="forum-links">
                        <li>
                            <h4 class= "text">Getting Verified</h4>
                            <ul>
                                <li>Once you have completed or provided 50 tasks, you are eligible to apply for verification. You must be able to provide identity verification details.</li>
                            </ul>
                        </li>
                        <li>
                            <h4 class= "text">Task completion</h4>
                            <ul>
                                <li>Job providers must mark each task as completed. If it doesn't happen within 3 days, the task will be marked as completed. If the job is completed but marked as not completed intentionally, seekers can report an issue to the admins.</li>
                            </ul>
                        </li>
                    </ul>
                    <div class="customer-service text-white container">
                        <h4>Didn't find what you were looking for?</h4>
                        <p class="help-text">
                            Contact our customer service or <br>send your questions using the <br> message button
                        </p>
                        <br>
                        <strong>
                            <h4 class="tel-no">+94 713757631 - Thimindu</h4>
                            <h4 class="email"><a href="" class="">quickgig@gmail.com</a></h4>
                        </strong>
                    </div>
                </div>

                <div class="forum">
                    <div class="article-card">
                        <h1>What are accepted identity verification documents?</h1>
                        <p class="text-grey text">
                            NIC, bills with your name and address, bank statements, or any other government-issued documents with your name and address.
                        </p>
                        <hr>
                        <div class="vote flex-row">
                            <p class="text-grey">Was this article helpful</p>
                            <button class="btn btn-trans">Yes</button>
                            <button class="btn btn-trans">No</button>
                        </div>
                    </div>
                    <hr>
                    <h1 class="my-qheading">My Questions</h1>
                    <div class="send-msg">
                        <form action="<?= ROOT . '/' . $currentController; ?>/submitQuestion" method="POST">
                            <h3><p class="text-grey text">Type your question</p></h3>
                            <br>
                            <div class="form-feild">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" placeholder="Enter the title of your question" required>
                            </div>
                            
                            <div class="form-feild">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="4" placeholder="Enter your question" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-accent"><i class="fa-solid fa-paper-plane"></i> Submit</button>
                        </form>
                    </div>
                </div>
            </div>



            <div class="my-questions container">
                <h2>My Questions</h2>
                
                <div class="tabs">
    <button class="tab-button active" data-tab="unreplied" onclick="showTab(this)">Unreplied Questions</button>
    <button class="tab-button" data-tab="replied" onclick="showTab(this)">Replied Questions</button>
</div>
                
                <div id="unreplied" class="tab-content active">
                    <?php 
                    $unrepliedQuestions = array_filter($questions, function($q) {
                        return empty($q->reply);
                    });
                    ?>
                    <?php if (!empty($unrepliedQuestions)): ?>
    <?php foreach ($unrepliedQuestions as $q): ?>
        <div class="question flex-col">
        <form method="POST">
    <div class="form-feild">
        <label for="title-<?= $q->helpID ?>">Title</label>
        <input type="text" id="title-<?= $q->helpID ?>" name="title" placeholder="Enter the title of your question" value="<?= htmlspecialchars($q->title) ?>" required>
    </div>

    <div class="form-feild">
        <label for="description-<?= $q->helpID ?>">Description</label>
        <textarea id="description-<?= $q->helpID ?>" name="description" rows="4" placeholder="Enter your question" required><?= htmlspecialchars($q->description) ?></textarea>
    </div>

    <button type="submit" class="btn btn-accent" formaction="<?= ROOT . '/' . $currentController; ?>/editQuestion/<?= $q->helpID ?>">
         Edit
    </button>

    <button type="submit" class="btn btn-del" formaction="<?= ROOT . '/' . $currentController; ?>/deleteQuestion/<?= $q->helpID ?>" onclick="return confirm('Are you sure you want to delete this question?');">
         Delete
    </button>
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
    <p>No unreplied questions!</p>
<?php endif; ?>

                </div>
                
                <div id="replied" class="tab-content">
                    <?php 
                    $repliedQuestions = array_filter($questions, function($q) {
                        return !empty($q->reply);
                    });
                    ?>
                    <?php if (!empty($repliedQuestions)): ?>
                        <?php foreach ($repliedQuestions as $q): ?>
                            <div class="question flex-col">
                                <h3><?= htmlspecialchars($q->title) ?></h3>
                                <p><?= htmlspecialchars($q->description) ?></p>
                                
                                <form method="POST" action ="<?= ROOT ?>/manager/reply/<?= $q->helpID ?>">
                                    <textarea name="reply" placeholder="Send a reply" style="background-color: hsla(116, 76%, 87%, 1);"><?= htmlspecialchars($q->reply) ?></textarea>
                                    
                                </form>
                                
                                <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                                    <?php 
                                        $timestamp = $q->createdAt;
                                        $date = date('Y-m-d', strtotime($timestamp));
                                        $time = date('H:i:s', strtotime($timestamp)); 
                                    ?>                       
                                    <p style="font-size : 11px;">Asked on <?= $date ?> at <?= $time ?></p>
                                    <!-- <p style="font-size : 11px;">Answered by <?= htmlspecialchars($q->fname). " " .htmlspecialchars($q->lname) ?></p> -->
                                </div>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No replied questions!</p>
                        
                    <?php endif; ?>
                </div>
            </div>
                        
            
            <script>
                function showTab(button) {
    const tabId = button.getAttribute('data-tab');
    const tabs = document.querySelectorAll('.tab-content');
    const buttons = document.querySelectorAll('.tab-button');

    tabs.forEach(tab => tab.classList.remove('active'));
    buttons.forEach(btn => btn.classList.remove('active'));

    document.getElementById(tabId).classList.add('active');
    button.classList.add('active');
}

            </script>


    <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            unset($_SESSION['error']);
        ?>

    
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
