<nav class="navbar">
  <div class="nav-left">
    <img  class="logo" src="<?=ROOT?>/assets/images/QuickGiglLogo.png" alt = "Logo">
    <ul class="nav-left-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">Categories</a></li>
    </ul>
  </div>
  <div class="hamburger" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <ul class="nav-links">
    <a href="<?php echo BASEURL; ?>/login"><button class="login-btn">Log in</button></a>
    <div class="divider"></div>
    <a href="<?php echo BASEURL; ?>/signup"><li><button class="sign-up-btn">Sign Up</button></li></a>
  </ul>
</nav>