<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php include APPROOT . '/views/components/navbar.php'; ?>

    <link rel="stylesheet" href="<?=ROOT?>/assets/css/user/editprofile.css">
    
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
        <div class="user-editprofile">
            <div class="editprofile-section 1">
                <div class="section1-left">
                    <h2>Profile Photo</h2>
                    <p>This image will be shown publicly as your 
                        profile picture, it will help recruiters recognize you!</p>
                </div>

                <div class="section1-right">
                    <img  class="edit-profile-photo" src="<?=ROOT?>/assets/images/person1.jpg" alt = "edit-profile-photo">
                </div>
            </div>
            <br><hr><br>

            <div class="editprofile-section 2">
                <div class="section2-left">
                    <h2>Personal Details</h2>
                </div>

                <div class="section2-right">
                    <label><strong>Title</strong></label><br>
                    <input type="text" class="custom-input part2" placeholder="Farm Owner"><br><br>

                    <label><strong>Location</strong></label><br>
                    <input type="text" class="custom-input part3" placeholder="Manchester, UK"><br><br>
                </div>
            </div>
            <br><hr><br>

            <div class="editprofile-section 3">
                <div class="section2-left">
                    <h2>Additional Details</h2>
                </div>

                <div class="section2-right">
                    <label><strong>Email</strong></label><br>
                    <input type="text" class="custom-input part1" placeholder="jakegyll@gmail.com"><br><br>
                    
                    <label><strong>Phone</strong></label><br>
                    <input type="text" class="custom-input part2" placeholder="+44 1245 572 135"><br><br>

                    <label><strong>Language</strong></label><br>
                    <input type="text" class="custom-input part3" placeholder="English, French"><br><br>
                </div>
            </div>
            <br><hr><br>

            <div class="editprofile-section 4">
                <div class="section2-left">
                    <h2>Social Links</h2>
                </div>

                <div class="section2-right">
                    <label><strong>Instagram</strong></label><br>
                    <input type="text" class="custom-input part1" placeholder="instagram.com/jakegyll"><br><br>
                    
                    <label><strong>Twitter</strong></label><br>
                    <input type="text" class="custom-input part2" placeholder="twitter.com/jakegyll"><br><br>

                    <label><strong>Website</strong></label><br>
                    <input type="text" class="custom-input part3" placeholder="www.jakegyll.com"><br><br>
                </div>
            </div>
            <br><hr><br>

            <div class="edit-profile-description">
                <h2>Description</h2>
                <input type="text" class="custom-input part4" placeholder="With years of experience in farming, I'm seeking reliable and motivated individuals to assist with daily farm tasks. Our farm, spanning over 150 acres, is a lush, green oasis teeming with life. We cultivate a variety of crops, including wheat, cabbage, carrots. Our farm is home to cows, chickens, ducks, goats and pigs, which contribute to a sustainable and harmonious ecosystem. We provide a comfortable and safe working environment for our workers, with access to clean water and basic amenities."><br><br>
            </div>

            <div class="edit-profile-btnsection">
                <input type="submit" value="Confirm Changes" class="edit-profile-btn">
            </div>

        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
