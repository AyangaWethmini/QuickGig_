<nav class="navbar">
  <div class="nav-left">
    <a href="<?=ROOT?>/home"><img class="logo" src="<?=ROOT?>/assets/images/QuickGiglLogo.png" alt="Logo"></a>
    <ul class="nav-left-links">
      <li><a href="#">About</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
  </div>
  <div class="hamburger" style="margin-right: 30px;" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <ul class="nav-links">
    <?php 
      // Check if the user is on the login or signup page
      $current_page = basename($_SERVER['REQUEST_URI']);
      if ($current_page !== 'login' && $current_page !== 'signup') : 
    ?>
      <?php if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']): ?>
        <a href="<?=ROOT?>/home/login">
          <li><button class="login-btn">Log in</button></li>
        </a>
        <div class="divider"></div>
        <a href="<?=ROOT?>/home/signup">
          <li><button class="sign-up-btn">Sign Up</button></li>
        </a>
      <?php else: ?>
        <div class="flex-row" style="gap: 10px;">
          <form action="<?=ROOT?>/login/logout" method="POST" style="display: inline;">
            <button type="submit" class="sign-up-btn" style="background-color:#ff0f0f;">Log Out</button>
          </form>
          <li>
        </div>
        <a href="<?=ROOT?>/jobProvider/individualProfile">
          <button class="profile-btn" style="background-image: url('<?=ROOT?>/assets/images/default.jpg');"></button>
        </a>
      </li>
      <?php endif; ?>
    <?php endif; ?>
  </ul>
</nav>
