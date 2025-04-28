<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/login.css">

 
<div class="login-login flex-row">

    <div class="carousel">
        <div class="slides">
            <div class="slide active" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel1.jpg');">
                <div class="overlay">
                    <h2>Welcome Back!</h2>
                    <p>Explore job opportunities that match your skills.</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel2.jpg');">
                <div class="overlay">
                    <h2>Flexible Hours</h2>
                    <p>Choose when and where you want to work.</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel3.jpg');">
                <div class="overlay">
                    <h2>Build Your Career</h2>
                    <p>Gain experience while you study. Get ahead.</p>
                </div>
            </div>
        </div>
        <div class="dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <div class="form-section">
        <div class="login-form">
            <a href="<?php echo ROOT; ?>/home" class="back-button">
                <
            </a>
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
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password" placeholder="Enter password" onpaste="return false" oncopy="return false" oncut="return false">
                            <button type="button" id="togglePassword">
                                👁️
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-accent login-btn" type="submit">Log In</button>
            </div>
            <div style="margin-left: 10px;">

                <p class="text-white styled login" style="font-size: 13px;color:white;">
                    Don't have an account?
                    <a href="<?php echo ROOT; ?>/home/signup" style="color: #00bfff; font-weight: bold;">Sign Up</a>
                </p>
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
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
            dots[i].classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });

    setInterval(nextSlide, 5000); // change slide every 5 seconds

    showSlide(currentSlide); // initialize
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>