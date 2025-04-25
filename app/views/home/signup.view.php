<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/signup.css">

<div class="signin-signup">

    <div class="carousel">
        <div class="slides">
            <div class="slide active" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel1.jpg');">
                <div class="overlay">
                    <h2>Welcome Aboard!</h2>
                    <p>Start your journey with us and explore job opportunities that fit your schedule.</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel2.jpg');">
                <div class="overlay">
                    <h2>Flexible Opportunities</h2>
                    <p>Get access to a wide range of jobs with flexible hours. Work when and where you want!</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel3.jpg');">
                <div class="overlay">
                    <h2>Build Your Future</h2>
                    <p>Join a platform that helps you gain valuable experience while studying. Secure your future today!</p>
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
        <div class="signup-form-wrapper">
            <div></div>
            <a href="<?php echo ROOT; ?>/home" class="back-button">
                <
            </a>
            <h3 class="heading">Create your account</h3>

            <!-- Error messages from PHP session -->
            <?php if (isset($_SESSION['signup_errors']) && !empty($_SESSION['signup_errors'])): ?>
                <div class="error-messages ">
                    <?php foreach ($_SESSION['signup_errors'] as $error): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['signup_errors']); ?>
            <?php endif; ?>

            <form action="<?php echo ROOT; ?>/signup/register" method="POST" onsubmit="return validateForm()" class="signup-form">
                <div class="form-field">
                    <label class="lbl" for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>

                <div class="form-field">
                    <label for="password" class="lbl">Password :</label><br>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Enter password">
                        <button type="button" id="togglePassword1">
                            👁️
                        </button>
                    </div>
                </div>

                <div class="form-field">
                    <label for="confirm-password" class="lbl">Confirm Password :</label><br>
                    <div class="password-wrapper">
                        <input type="password" name="confirm-password" id="confirm-password" placeholder="Enter password">
                        <button type="button" id="togglePassword2">
                            👁️
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-accent signup-btn">Sign Up</button>
            </form>

            <div class="bottom-text">
                <p class="text-muted">Already have an account?
                    <a href="<?php echo ROOT; ?>/home/login" class="link">Log In</a>
                </p>

            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById('email').addEventListener('input', function(e) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const isValid = emailPattern.test(e.target.value);
        e.target.setCustomValidity(isValid ? '' : 'Please enter a valid email address.');
    });
</script>
<script>
    document.getElementById('togglePassword1').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const isPassword = passwordField.type === 'password';
        passwordField.type = isPassword ? 'text' : 'password';
        this.textContent = isPassword ? '🙈' : '👁️';
    });

    document.getElementById('togglePassword2').addEventListener('click', function() {
        const confirmPasswordField = document.getElementById('confirm-password');
        const isPassword = confirmPasswordField.type === 'password';
        confirmPasswordField.type = isPassword ? 'text' : 'password';
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