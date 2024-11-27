<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/login.css">

<div class="signin-signup flex-row">

    <div class="image">
        <p class="logo">QuickGig.</p>
            <img src="<?=ROOT?>/assets/images/home.png" alt="man holding files" class="img">

            <div class="stat container flex-col">
                <img src="<?=ROOT?>/assets/icons/chart.svg" alt="stats image" width="56px" height="40px">
                <h4>100k+</h4>
                <p>People got hired</p>
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

    <div class="form-section">
    <div class="login-form">
        <div class="flex-col" style="justify-content: center;">
        <h3 style="color: var(--color-white); margin-top: 40px;">Get more oppertunities</h3>
        <form action="post" class="form-body" >
            <div class="form-field">
                <label for="email" class="lbl" style="color: var(--color-white);">Email : </label><br>
                <input type="text" placeholder="Enter Email">
            </div>

            <div class="form-field">
                <label for="password" class="lbl" style="color: var(--color-white);">Password :</label><br>
                <input type="password" placeholder="Enter password"> <!----add the width to css file -->
            </div>
            <p class="text-white rem">Remember me<input type="checkbox"></p>
            
            
            <button class="btn btn-accent signup-btn">Sign Up</button>
        </div>
            <div style="margin-left: 10px;">
                
                <p class="text-white styled login" style="font-size: 13px;">Already have an account ? <a href="#">login</a></p>
                <p class="text-white styled login" style="font-size: 13px;">By clicking 'Continue', you acknowledge that you have read and accept the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
        </form>
    </div>
    </div>

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>