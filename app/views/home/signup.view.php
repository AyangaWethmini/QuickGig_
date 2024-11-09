<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/signup.css">
<div class="signin-signup flex-row">

    <div class="image">
        <p class="logo">QuickGig.</p>
        <img src="<?=ROOT?>/assets/images/home.png" alt="man holding files" class="img">

        <div class="stat container flex-col">
            <img src="<?=ROOT?>/assets/icons/chart.svg" alt="stats image" width="56px" height="40px">
            <h4 class="h4-stat">100k+</h4>
            <p class="styled">People got hired</p>
        </div>

        <div class="testamonial container">
            <img src="<?=ROOT?>/assets/images/profile.png" alt="profile picture" class="profile">
            <div class="card">
                <h5>Adam Slander</h5>
                <h5>Lead Engineer at Canva</h5>
                <div class=" flex-row">
                <p class="quote">"</p>
                <p class="comment">“Great platform for the job seeker that searching for new career heights.”</p>
                </div>

            </div>
        
        </div>
    </div>



    <div class="form flex-col">

        <div class="buttons flex-row">
            <button class="form-btn btn" id="individual" onclick="individualSignUp()" >Individual</button>
            <button class="form-btn btn" id="company" onclick="companySignUp()">Company</button>
        </div>

        <div class="flex-col">
        <h3 class="heading">Get more oppertunities</h3>
        <form action="post">
            <div class="form-field" id="ind-name">
                <label for="name" class="lbl"><span id="name">Name :</span></label><br>
                <input type="text" placeholder="Enter your name">
            </div>
            <div class="form-field" id="com-name">
                <label for="name" class="lbl"><span id="name">Name :</span></label><br>
                <input type="text" placeholder="Enter your name">
            </div>

            <div class="form-field">
                <label for="email" class="lbl">Email : </label><br>
                <input type="text" placeholder="Enter Email">
            </div>

            <div class="form-field">
                <label for="password" class="lbl">Password :</label><br>
                <input type="password" placeholder="Enter password" width="250px"> <!----add the width to css file -->
            </div>

            <button class="btn btn-accent signup-btn">Sign Up</button>
        </div>
            <div style="margin-left: 10px;">
                <p class="text-grey">Already have an account ? <a href="<?APPROOT?>/views/home/login.view.php">login</a></p>
                <p class="text-grey">By clicking 'Continue', you acknowledge that you have read and accept the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
        </form>
    </div>
</div>

<script>


    const companyButton = document.getElementById("company");
    const individualButton = document.getElementById("individual");

    const nameLabel = document.getElementById("name");

    companyButton.addEventListener("click", function() {
        companySignUp();
    });

    individualButton.addEventListener("click", function() {
        individualSignUp();
    });

    function companySignUp() {
        nameLabel.innerHTML = "Organization name"; label
        companyButton.classList.add('active');      
        individualButton.classList.remove('active'); }

    function individualSignUp() {
        nameLabel.innerHTML = "Name";               
        individualButton.classList.add('active');   
        companyButton.classList.remove('active');  
    }


</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>
