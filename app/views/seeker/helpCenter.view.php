<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/help.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    <div class="main-content container flex-col">
        <div class="header container flex-row">
            <h3>Help Center</h3>
            <button class="btn btn-trans">Back To homepage</button>
        </div>

        <div class="help-dashboard flex-row">
            <div class="suggestions">
                <label for="search-prompt"><p class="text-grey lbl">Type your question or search keyword</p></label><br>
                <div class="search-container">
                    <input type="text" 
                        class="search-bar" 
                        placeholder="Search"
                        aria-label="Search">
                </div>
                <div class="forum-links">
                    <a href="#" class="">Getting Started</a>
                    <hr>
                    <a href="#" class="">My Profile</a>
                    <hr>
                    <a href="#" class="">Request for an employee</a>
                    <hr>
                    <a href="#" class="">Getting Started</a>
                    <hr>
                    <a href="#" class="">Getting Started</a>
                    <hr>
                </div>
                <div class="customer-service text-white container">
                    <h4>Didn't find what your were looking for?</h4>
                    <p class="help-text">
                        Contanct our customer service or <br>send your questions using the <br> message button
                    </p>
                    <p class="tel-no">
                        +94 713757631 - Thimindu
                    </p>
                    <p class="email"><a href="" class="">quickgig@gmail.com</a></p>
                </div>
                <div class="send-msg">
                    <p class="text-grey text">Type your question</p>
                    <span><input type="text" for="question"><i class="fa-solid fa-paper-plane"></i></span>
                </div>

            </div>
            <hr>
            <div class="forum">
                <div class="sort-container">
                    <span class="label">Sort by:</span>
                    <select>
                        <option value="most-relevant">Most relevant</option>
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="top-rated">Top rated</option>
                    </select>
                </div>

                <div class="article-card">
                    <h1>What is My Applications?</h1>
                    <p class="text-grey text">
                    My Applications is a way for you to track jobs as you move through the application process. Depending on the job you applied to, you may also receive notifications indicating that an application has been actioned by an employer.
                    </p>
                    <hr>
                    <div class="vote flex-row">
                        <p class="text-grey">Was this article helpful</p>
                        <button class="btn btn-trans">Yes</button>
                        <button class="btn btn-trans">No</button>
                    </div>
                </div>

                <div class="article-card">
                    <h1>What is My Applications?</h1>
                    <p class="text-grey text">
                    My Applications is a way for you to track jobs as you move through the application process. Depending on the job you applied to, you may also receive notifications indicating that an application has been actioned by an employer.
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
                <div class="my-questions container">
                    <h2>Questions i sent previously</h2>
                </div>
            </div>
        </div>
        
    
    </div>

</div>




<?php require APPROOT . '/views/inc/footer.php'; ?>