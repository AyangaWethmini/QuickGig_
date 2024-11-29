<?php require APPROOT . '/views/inc/header.php'; ?> 
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);?>
<?php include APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/profile.css">


<div class="wrapper flex-row" style="margin-top: 100px;">

    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container flex-col">
    <div class="header">
            <h3>Profile</h3>
            
</div>
<hr>
        

        <section class="profile-manager flex-row container">
            <!-- Profile Image Section -->
            <div class="profile-image container">
                <img src="<?=ROOT?>/assets/images/profile.png" alt="Profile Image">
            </div>

            <!-- Profile Details Section -->
            <div class="profile-details container">
                <div class="user-info">
                    <p class="role lbl"><strong>Role:</strong> Manager</p>
                    <p class="name lbl"><strong>Name:</strong> Maria</p>
                    <p class="email lbl"><strong>Email:</strong> maria@gmail.com</p>
                </div>

                <!-- Form to Update Email -->
                <form class="profile-form" id="emailForm" method="POST" action="<?=ROOT?>/manager/updateEmail">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
                    <div class="form-group">
                        <label for="email"><p class="lbl">Change Email:</p></label>
                        <div class="input-group">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                placeholder="Enter your new email" 
                                required 
                                class="form-input">
                            <button class="btn btn-accent" onclick="showConfirmation()">Change</button>
                        </div>
                    </div>
                </form>

                <!-- Form to Update Password -->
                <form class="profile-form" id="passwordForm" method="POST" action="<?=ROOT?>/manager/updatePassword">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
                    <div class="form-group">
                        <label for="password"><p class="lbl">Change Password</p></label>
                        <div class="input-group">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Enter your new password" 
                                required 
                                minlength="6" 
                                class="form-input">
                            <button class="btn btn-accent" onclick="showConfirmation()">Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>


    </div>
        




         
        


        
    
</div>


<div class="confirmation-modal">
    <h3>Confirmation</h3>
    <p id="confirmation-message">Are you sure you want to proceed?</p>
    <button class="btn btn-accent" type="submit" >Yes</button>
    <button class="btn btn-accent">No</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailForm = document.getElementById('emailForm');
        const passwordForm = document.getElementById('passwordForm');
        const confirmationMessage = document.getElementById('confirmation-message');

        emailForm.addEventListener('submit', function(e) {
            confirmationMessage.textContent = 'Are you sure you want to change your email?';
        });

        passwordForm.addEventListener('submit', function(e) {
            confirmationMessage.textContent = 'Are you sure you want to change your password?';
        });
    });
</script>



