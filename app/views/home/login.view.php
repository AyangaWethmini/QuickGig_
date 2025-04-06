<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/login.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>


<div class="login-login flex-row">

    <div class="image">
        <img src="<?= ROOT ?>/assets/images/home.png" alt="man holding files" class="img">

        <div class="stat container flex-col">
            <img src="<?= ROOT ?>/assets/icons/chart.svg" alt="stats image" width="56px" height="40px">
            <h4>100k+</h4>
            <p>People got hired</p>
        </div>

        <div class="testamonial container">
            <img src="<?= ROOT ?>/assets/images/profile.png" alt="profile picture" class="profile">
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
            <div class="flex-col">
                <h3 class="heading">WELLCOME BACK!</h3>
                <form action="<?php echo ROOT; ?>/login/verify" method="POST" class="form-body">
                    <!-- Display errors -->
                    <?php if (isset($_SESSION['login_errors']) && !empty($_SESSION['login_errors'])): ?>
                        <div class="error-messages">
                            <?php foreach ($_SESSION['login_errors'] as $error): ?>
                                <p class="error"><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <?php unset($_SESSION['login_errors']); ?>
                    <?php endif; ?>

                    <div class="form-field">
                        <label for="email" class="lbl">Email : </label><br>
                        <input type="text" name="email" placeholder="Enter Email">
                    </div>

                    <div class="form-field">
                        <label for="password" class="lbl">Password :</label><br>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Enter password" style="padding-right: 30px;">
                            <button type="button" id="togglePassword" style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer;">
                                👁️
                            </button>
                        </div>
                    </div>
                    <div class="rem">
                        <input type="checkbox">
                        <p class="lbl">Remember me</p>
                    </div>

                    <button class="btn btn-accent login-btn" type="submit">Log In</button>
            </div>
            <div style="margin-left: 10px;">

                <p class="text-white styled login" style="font-size: 13px;">
                    Don't have an account?
                    <a href="<?php echo ROOT; ?>/home/signup" style="color: #00bfff; font-weight: bold;">Sign Up</a>
                </p>

                <p class="text-white styled login" style="font-size: 13px;">By clicking 'Continue', you acknowledge that you have read and accept the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
            </form>
        </div>
    </div>

</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const isPassword = passwordField.type === 'password';
        passwordField.type = isPassword ? 'text' : 'password';
        // Change the button text/icon
        this.textContent = isPassword ? '🙈' : '👁️';
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>