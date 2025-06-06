<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/home.css">

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/contactUs.css">


<div class="contact-us">
    <div class="form-card">
    <h1>Contact Us</h1>
    <p>If you have any questions or feedback, feel free to reach out!</p>

    <form action="<?= ROOT ?>/home/sendEmail" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>

        <button type="submit" class="btn-accent">Send Message</button>
    </div>


        <?php
        include_once APPROOT . '/views/components/alertBox.php';
        if (isset($_SESSION['error'])) {
            echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
        }
        if (isset($_SESSION['success'])) {
            echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
        }
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        ?>

        
    </form>



</div>
<footer class="footer">
    <div class="footer-content">
        <div class="footer-logo-section">
            <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="QuickGig Logo" class="footer-logo" />
            <p class="footer-text">
                Great platform for job seekers who<br>
                are passionate about startups. Find<br>
                your dream job easier.
            </p>
        </div>

        <div class="footer-links">
            <a href="<?= ROOT ?>/home/aboutUs">About Us</a>
            <a href="<?= ROOT ?>/home/contact">Contact Us</a>
        </div>
    </div>

    <hr class="footer-divider">
    <p class="copyright">&copy; 2024 QuickGig. All rights reserved.</p>
</footer>

