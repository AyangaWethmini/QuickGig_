<?php require APPROOT . '/views/inc/header.php'; ?> 
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
                <form class="profile-form" method="POST" action="<?=ROOT?>/manager/updateEmail">
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
                            <button type="submit" class="btn btn-accent">Change</button>
                        </div>
                    </div>
                </form>

                <!-- Form to Update Password -->
                <form class="profile-form" method="POST" action="<?=ROOT?>/manager/updatePassword">
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
                            <button type="submit" class="btn btn-accent">Change</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>


    </div>
        




        

        
        


        
    
</div>




