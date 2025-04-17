<?php $path = allocatePathBasedOnRole(); ?>
<?php
$profilePic = ROOT . "/assets/images/default.jpg"; // Default profile picture

if (isset($_SESSION['pp']) && !empty($_SESSION['pp'])) {
    $profilePic = "data:image/jpeg;base64," . base64_encode($_SESSION['pp']);
}
?>
<nav class="navbar">
  <div class="nav-left">
    <div class="hamburger" onclick="toggleMenu()">
    <img src= "<?=ROOT?>/assets/images/hamburger.png" alt="Hamburger Icon">
     
    </div>
    <a href="<?=ROOT?>/home"><img class="logo nav-left-links" src="<?=ROOT?>/assets/images/QuickGiglLogo.png" alt="Logo"></a>
    <ul class="nav-left-links mobile-menu">
      <li class="nav-links-home"><a href="<?=ROOT?>/home">Home</a></li>
      <li><a href="<?php echo ROOT;?>/home/aboutUs">About</a></li>
      <li><a href="#">Contact Us</a></li>
      <li><a href="<?php echo ROOT;?>/subscription/premium"><i class="fa-solid fa-crown" style="color:rgb(200, 179, 62);"></i> Premium</a></li>
    </ul>
  </div>

  <ul class="nav-links">
    <?php 
      $current_page = basename($_SERVER['REQUEST_URI']);
      if ($current_page !== 'login' && $current_page !== 'signup') : 
    ?>
      <?php if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']): ?>
        <a href="<?=ROOT?>/home/login">
          <li><button class="login-btn">Log in</button></li>
        </a>
        <!-- Sign Up Button visible on larger screens only -->
        <a href="<?=ROOT?>/home/signup">
          <li><button class="sign-up-btn">Sign Up</button></li>
        </a>
      <?php else: ?>
        <div class="flex-row" style="gap: 10px;">
          <form action="<?=ROOT?>/login/logout" method="POST" style="display: inline;">
            <button type="submit" class="sign-up-btn" style="background-color:#ff0f0f;margin-top: 10px; margin-right: 5px;">Log Out</button>
          </form>
          <a href="<?php echo $path; ?>">
            <button class="profile-btn" style="background-image: url('<?= $profilePic; ?>');"></button>
          </a>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </ul>
</nav>
<script>
  function toggleMenu() {
    const mobileMenu = document.querySelector('.nav-left-links.mobile-menu');
    mobileMenu.classList.toggle('active');
  }
</script>

<?php
function allocatePathBasedOnRole() {
    // Default path in case roleID is not set or invalid
    $defaultPath = ROOT . "/home";

    // Check if roleID is set in the session
    if (isset($_SESSION['user_role'])) {
        switch ($_SESSION['user_role']) {
            case 0:
                return ROOT . "/admin/admindashboard";
            case 1:
                return ROOT . "/manager/dashboard";
            case 2:
                return ROOT . "/jobProvider/jobListing_received";
            case 3:
                return ROOT . "/organization/organizationProfile";
            default:
                return $defaultPath;
        }
    }
    return $defaultPath; // Redirect to login if roleID is not set
}

?>

