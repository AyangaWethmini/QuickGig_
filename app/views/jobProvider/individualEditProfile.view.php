<?php require APPROOT . '/views/inc/header.php'; ?>
    <?php include APPROOT . '/views/components/navbar.php'; ?>
    <div class="user-editprofile">
        <div class="editprofile-section 1">
            <div class="section1-left">
                <h2>Profile Photo</h2>
                <p>This image will be shown publicly as your 
                    profile picture, it will help recruiters recognize you!</p>
            </div>

            <div class="section1-right">
                <img  class="logo" src="<?=ROOT?>/assets/images/person1.jpg" alt = "Logo">
            </div>
        </div>
        <br><hr><br>

        <div class="editprofile-section 2">
            <div class="section2-left">
                <h2>Personal Details</h2>
            </div>

            <div class="section2-right">
                <label><strong>Full Name</strong></label><br>
                <input type="text" class="custom-input part1" placeholder="Enter your name"><br><br>
                
                <label><strong>Title</strong></label><br>
                <input type="text" class="custom-input part2" placeholder="Enter title"><br><br>

                <label><strong>Location</strong></label><br>
                <input type="text" class="custom-input part3" placeholder="Enter location"><br><br>
            </div>
        </div>
        <br><hr><br>

        <div class="editprofile-section 3">
            <div class="section2-left">
                <h2>Additional Details</h2>
            </div>

            <div class="section2-right">
                <label><strong>Email</strong></label><br>
                <input type="text" class="custom-input part1" placeholder="Enter email"><br><br>
                
                <label><strong>Phone</strong></label><br>
                <input type="text" class="custom-input part2" placeholder="Enter phone number"><br><br>

                <label><strong>Language</strong></label><br>
                <input type="text" class="custom-input part3" placeholder="Enter language"><br><br>
            </div>
        </div>
        <br><hr><br>

        <div class="editprofile-section 4">
            <div class="section2-left">
                <h2>Social Links</h2>
            </div>

            <div class="section2-right">
                <label><strong>Instagram</strong></label><br>
                <input type="text" class="custom-input part1" placeholder="Enter instagram"><br><br>
                
                <label><strong>Facebook</strong></label><br>
                <input type="text" class="custom-input part2" placeholder="Enter facebook"><br><br>

                <label><strong>Linkedn</strong></label><br>
                <input type="text" class="custom-input part3" placeholder="Enter linkedn"><br><br>
            </div>
        </div>
        <br><hr><br>

        <div>
            <h2>Description</h2>
            <input type="text" class="custom-input" placeholder="Enter description"><br><br>
        </div>

        <div class="edit-profile-btnsection">
            <input type="submit" value="Confirm Changes" class="form-btn edit-profile">
        </div>

    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
