<?php require APPROOT . '/views/inc/header.php'; ?>
<?php include APPROOT . '/views/components/navbar.php'; ?>

<script>
    // Include the toggleMenu function
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      navLinks.classList.toggle('active');
    }
</script>


<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/signup.css">

<div class="signin-signup flex-row">

    <div class="image">
        <img src="<?=ROOT?>/assets/images/home.png" alt="man holding files" class="img">

        <div class="stat container flex-col">
            <img src="<?=ROOT?>/assets/icons/chart.svg" alt="stats image" width="56px" height="40px">
            <h4 class="h4-stat">100k+</h4>
            <p class="styled">People got hired</p>
        </div>

        <div class="testamonial container">
            <img src="<?=ROOT?>/assets/images/profile.png" alt="profile picture" class="profile">
            <div class="card">
                <h5 class="rev-name">Adam Slander</h5>
                <h5>Lead Engineer at Canva</h5>
                <div class=" flex-row">
                <p class="quote">"</p>
                <p class="comment">“Great platform for the job seeker that searching for new career heights.”</p>
                </div>

            </div>
        
        </div>
    </div>



    <div class="form flex-col" style="width: 450px;">

        <div class="buttons flex-row">
            <button class="form-btn btn" id="individual" onclick="individualSignUp()" >Individual</button>
            <button class="form-btn btn" id="company" onclick="companySignUp()">Company</button>
        </div>

        <div class="flex-col">
        <h3 class="heading">Get more oppertunities</h3>

        <!-- Display errors -->
        <?php if (isset($_SESSION['signup_errors']) && !empty($_SESSION['signup_errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['signup_errors'] as $error): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['signup_errors']); ?>
            <?php endif; ?>
            
        <form action="<?php echo ROOT; ?>/signup/register" method="POST" class="signup-form">
            <!-- <div class="form-field" id="ind-name">
                <label for="name" class="lbl"><span id="name">Name :</span></label><br>
                <input type="text" placeholder="Enter your name">
            </div>
            <div class="form-field" id="com-name">
                <label for="name" class="lbl"><span id="name">Name :</span></label><br>
                <input type="text" placeholder="Enter your name">
            </div> -->

            <div class="form-field">
                <label for="email" class="lbl">Email : </label><br>
                <input type="text" name ="email" placeholder="Enter Email" required>
            </div>

            <div class="form-field">
                <label for="password" class="lbl">Password :</label><br>
                <input type="password" name="password" placeholder="Enter password" width="250px" required> <!----add the width to css file -->
            </div>

            <button class="btn btn-accent signup-btn" type = "submit" >Sign Up</button>
        </div>
        <br>
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
