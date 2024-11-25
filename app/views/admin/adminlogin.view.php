<?php require APPROOT . '/views/inc/header.php'; ?>
<h1>Admin Login</h1>
<div class="form-container">
    <form action="<?php echo ROOT; ?>/admin/adminlogin" method="POST">
        <!-- email-->
        <div class="form-input-title">Email</div>
        <input type="text" name="email" id="email" class="email" value="<?php echo $data['email']; ?>">
        <span class="form-invalid"><?php echo $data['email_err']; ?></span>

        <!-- password -->
        <div class="form-input-title">Password</div>
        <input type="password" name="password" id="password" class="password" value="<?php echo $data['password']; ?>">
        <span class="form-invalid"><?php echo $data['password_err']; ?></span>

        <input type="submit" value="Login">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>