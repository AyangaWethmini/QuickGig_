<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/home.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/aboutUs.css">

<div class="aboutUs--main-container">

  <main class="about-container">
    <section class="about-section">
      <h2>About Us</h2>
      <p>
        Welcome to <span class="highlight">QuickGig</span>, the platform that connects job seekers with short-term work opportunities.
        Whether you're looking for bartending, waiting tables, or helping as a fruit picker, we've got you covered!
      </p>
      <p>
        Our mission is simple: provide quick, no-commitment jobs where you can earn cash on-site after completing your task. No contracts. No hassle.
        Just show up, do the job, and get paid.
      </p>
    </section>

    <section class="features-section">
      <h3>Why Choose Us?</h3>
      <div class="features-grid">
        <div class="feature">
          <h4>Flexible Jobs</h4>
          <p>Pick work that fits your schedule with no long-term commitments.</p>
        </div>
        <div class="feature">
          <h4>Fast Payment</h4>
          <p>Get paid in cash immediately after finishing your shift.</p>
        </div>
        <div class="feature">
          <h4>Trusted Platform</h4>
          <p>We verify all job postings to ensure a safe and reliable experience.</p>
        </div>
      </div>
    </section>
  </main>

</div>
<footer class="footer" style="background-color: black;">
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