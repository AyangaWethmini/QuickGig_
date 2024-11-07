<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/signup.css">
<div class="signup flex-row">


    <div class="image">
        <img src="<?=ROOT?>/assets/images/home.png" alt="man holding files" class="img">

        <div class="stat container flex-col">
            <img src="<?=ROOT?>/assets/icons/chart.svg" alt="stats image" width="56px" height="40px">
            <h4>100k+</h4>
            <p>People got hired</p>
        </div>
    </div>



    <div class="form">
        <div class="buttons flex-row">
        <button class="form-btn" id="individual" onclick="individualSignUp()" >Individual</button>
        <button class="form-btn" id="company" onclick="companySignUp()">Company</button>
        </div>
        <div class="flex-col">
        <h3>Get more oppertunities</h3>
        <form action="post">
            <div class="form-field" id="ind-name">
                <label for="name"><span id="name">Name :</span></label><br>
                <input type="text" placeholder="Enter your name">
            </div>
            <div class="form-field" id="com-name">
                <label for="name"><span id="name">Name :</span></label><br>
                <input type="text" placeholder="Enter your name">
            </div>

            <div class="form-field">
                <label for="email">Email : </label><br>
                <input type="text" placeholder="Enter Email">
            </div>

            <div class="form-feild">
                <label for="password">Password :</label><br>
                <input type="password" placeholder="Enter password">
            </div>

            <button class="btn btn-accent">Sign Up</button>
        </div>
            <p>Already have an account ? <a href="#">login</a></p>
            <p>By clicking 'Continue', you acknowledge that you have read and accept the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
        </form>
    </div>
</div>

<script>

    function companySignUp(){
        document.getElementById("name").innerHTML = "Organization name";
    }

    function individualSignUp(){
        document.getElementById("name").innerHTML = "Name";
    }
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>
