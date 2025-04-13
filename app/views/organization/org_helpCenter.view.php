<?php 
require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);
require APPROOT . '/views/components/navbar.php'; 
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/help.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="wrapper flex-row">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content container flex-col">
        <!-- Header -->
        <div class="header container flex-row">
            <h3>Help Center</h3>
        </div>

        <!-- Help Dashboard -->
        <div class="help-dashboard flex-row">
            <!-- Suggestions Section -->
            <div class="suggestions">
                <!-- Search -->
                <!-- <label for="search-prompt">
                    <p class="text-grey lbl">Type your question or search keyword</p>
                </label>
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search" aria-label="Search">
                </div> -->

                <!-- Forum Links -->
                <div class="forum-links">
                    <a href="#">Getting Started</a><hr>
                    <a href="#">My Profile</a><hr>
                    <a href="#">Request for an employee</a><hr>
                    <a href="#">Getting Started</a><hr>
                    <a href="#">Getting Started</a><hr>
                </div>

                <!-- Customer Service -->
                <div class="customer-service text-white container">
                    <h4>Didn't find what you were looking for?</h4>
                    <p class="help-text">
                        Contact our customer service or <br>send your questions using the <br> message button
                    </p>
                    <p class="tel-no">+94 713757631 - Thimindu</p>
                    <p class="email"><a href="mailto:quickgig@gmail.com">quickgig@gmail.com</a></p>
                </div>

                
            </div>


            <!-- Forum Section -->
            <div class="forum">
                <h1 class="my-heading">My Questions</h1>
                <!-- Send Message -->
                <div class="send-msg">
                    <p class="text-grey text">Type your question</p>
                    <span>
                        <input type="text" for="question">
                        <i class="fa-solid fa-paper-plane"></i>
                    </span>
                </div>
                <div class="my-questions container">
                    <h2>Questions I sent previously</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
