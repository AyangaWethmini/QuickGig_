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
      <img src="<?= ROOT ?>/assets/images/hamburger.png" alt="Hamburger Icon">

    </div>
    <a href="<?= ROOT ?>/home"><img class="logo nav-left-links" src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="Logo"></a>
    <?php if ((isset($_SESSION['user_role']) && $_SESSION['user_role'] > 1) || !isset($_SESSION['user_role'])): ?>
      <ul class="nav-left-links mobile-menu">
        <li class="nav-links-home"><a href="<?= ROOT ?>/home">Home</a></li>
        <li><a href="<?php echo ROOT; ?>/home/aboutUs">About</a></li>
        <li><a href="<?php echo ROOT; ?>/home/contact">Contact Us</a></li>
        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
          <li><a href="<?php echo ROOT; ?>/subscription/premium"><i class="fa-solid fa-crown" style="color:rgb(200, 179, 62);"></i> Premium</a></li>
        <?php endif; ?>
        <li><a href="<?php echo ROOT; ?>/advertise">Advertise</a></li>
      </ul>
    <?php endif; ?>
  </div>

  <ul class="nav-links">
    <?php
    $current_page = basename($_SERVER['REQUEST_URI']);
    if ($current_page !== 'login' && $current_page !== 'signup') :
    ?>
      <?php if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']): ?>
        <a href="<?= ROOT ?>/home/login">
          <li><button class="login-btn">Log in</button></li>
        </a>
        <!-- Sign Up Button visible on larger screens only -->
        <a href="<?= ROOT ?>/home/signup">
          <li><button class="sign-up-btn">Sign Up</button></li>
        </a>
      <?php else: ?>
        <div class="flex-row" style="gap: 10px;">
          <?php
          $hidden_pages = ['home', 'aboutUs', 'contact', 'premium', 'advertise'];
          if (!in_array($current_page, $hidden_pages)):
          ?>
            <?php if (isset($_SESSION['current_role']) && $_SESSION['user_role'] == 2 && $_SESSION['current_role'] == 1): ?>
              <span class="nav-links-role provider-role">
                <i class="fa-solid fa-briefcase"></i> Job Provider
              </span>
            <?php elseif (isset($_SESSION['current_role']) && $_SESSION['user_role'] == 2 && $_SESSION['current_role'] == 2): ?>
              <span class="nav-links-role seeker-role">
                <i class="fa-solid fa-user"></i> Job Seeker
              </span>
            <?php endif; ?>
          <?php endif; ?>
          <button id="logout-btn" type="button" class="sign-up-btn" onclick="showLogoutConfirmation()" style="background-color:#ff0f0f;margin-top: 10px; margin-right: 5px;">
            Log Out
          </button>

          <div id="logout-confirmation" style="display:none; margin-top: 10px; gap: 10px;">
            <form action="<?= ROOT ?>/login/logout" method="POST" style="display: inline;">
              <button type="submit" class="sign-up-btn" style="background-color:#28a745;">Confirm</button>
            </form>
            <button type="button" class="sign-up-btn" onclick="hideLogoutConfirmation()" style="background-color:#007bff;">Stay</button>
          </div>

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
<script>
function showLogoutConfirmation() {
  const confirmationBox = document.getElementById('logout-confirmation');
  const logoutBtn = document.getElementById('logout-btn');
  confirmationBox.style.display = 'flex';
  logoutBtn.style.display = 'none'; // Hide the Log Out button
}

function hideLogoutConfirmation() {
  const confirmationBox = document.getElementById('logout-confirmation');
  const logoutBtn = document.getElementById('logout-btn');
  confirmationBox.style.display = 'none';
  logoutBtn.style.display = 'inline-block'; // Show the Log Out button again
}
</script>


<?php
function allocatePathBasedOnRole()
{
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
        return ROOT . "/jobProvider/individualProfile";
      case 3:
        return ROOT . "/organization/organizationProfile";
      default:
        return $defaultPath;
    }
  }
  return $defaultPath; // Redirect to login if roleID is not set
}

?>