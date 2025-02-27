<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php include APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/editprofile.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <form action="<?= ROOT ?>/JobProvider/updateProfile" method="POST" enctype="multipart/form-data">
        <div class="user-editprofile">
            <div class="editprofile-section 1">
                <div class="section1-left">
                    <h2>Profile Photo</h2>
                    <p>This image will be shown publicly as your
                        profile picture, it will help recruiters recognize you!</p>
                </div>

                <div class="section1-right">
                    <label for="profile-upload" class="profile-upload-label">
                        <img id="profile-preview" class="edit-profile-photo"
                            src="<?= !empty($data['pp']) ? 'data:image/jpeg;base64,' . base64_encode($data['pp']) : ROOT . '/assets/images/default.jpg' ?>"
                            alt="Profile Photo">
                    </label>
                    <input type="file" id="profile-upload" name="pp" accept="image/*" style="display: none;">
                </div>


            </div>
            <br>
            <hr><br>

            <div class="editprofile-section 2">
                <div class="section2-left">
                    <h2>Personal Details</h2>
                </div>

                <div class="section2-right">
                    <label><strong>Name</strong></label><br>
                    <input type="text" name="fname" class="custom-input part2" placeholder="John" value="<?= htmlspecialchars(($data['fname'] ?? '')) ?>"><br><br>
                    <input type="text" name="lname" class="custom-input part2" placeholder="Doe" value="<?= htmlspecialchars(($data['lname'] ?? '')) ?>"><br><br>
                    <label><strong>Location</strong></label><br>
                    <input type="text" name="addressLine1" class="custom-input part3" placeholder="Manchester, UK" value="<?= htmlspecialchars(($data['addressLine1'] ?? '')) ?>"><br><br>
                    <input type="text" name="addressLine2" class="custom-input part3" placeholder="Manchester, UK" value="<?= htmlspecialchars(($data['addressLine2'] ?? '')) ?>"><br><br>
                    <input type="text" name="city" class="custom-input part3" placeholder="Manchester, UK" value="<?= htmlspecialchars(($data['city'] ?? '')) ?>"><br><br>
                </div>
            </div>
            <br>
            <hr><br>

            <div class="editprofile-section 3">
                <div class="section2-left">
                    <h2>Additional Details</h2>
                </div>

                <div class="section2-right">
                    <label><strong>Email</strong></label><br>
                    <input type="text" name="email" class="custom-input part1" placeholder="jakegyll@gmail.com" value="<?= htmlspecialchars(($data['email'] ?? '')) ?>"><br><br>

                    <label><strong>Phone</strong></label><br>
                    <input type="text" name="phone" class="custom-input part2" placeholder="+44 1245 572 135" value="<?= htmlspecialchars(($data['phone'] ?? '')) ?>"><br><br>

                    <label><strong>District</strong></label><br>
                    <input type="text" name="district" class="custom-input part3" placeholder="Male/Female" value="<?= htmlspecialchars(($data['district'] ?? '')) ?>"><br><br>
                </div>
            </div>
            <br>
            <hr><br>

            <div class="editprofile-section 4">
                <div class="section2-left">
                    <h2>Social Links</h2>
                </div>

                <div class="section2-right">
                    <label><strong>LinkedIn</strong></label><br>
                    <input type="text" name="linkedIn" class="custom-input part1" placeholder="LinkedIn.com/jakegyll" value="<?= htmlspecialchars(($data['linkedIn'] ?? '')) ?>"><br><br>

                    <label><strong>FaceBook</strong></label><br>
                    <input type="text" name="facebook" class="custom-input part2" placeholder="facebook.com/jakegyll" value="<?= htmlspecialchars(($data['facebook'] ?? '')) ?>"><br><br>

                    <label><strong>Website</strong></label><br>
                    <input type="text" class="custom-input part3" placeholder="www.jakegyll.com"><br><br>
                </div>
            </div>
            <br>
            <hr><br>

            <div class="edit-profile-description">
                <h2>Description</h2>
                <textarea name="bio" class="custom-input part4"
                    placeholder="Your description here"
                    maxlength="6000"><?= htmlspecialchars(($data['bio'] ?? '')) ?></textarea>

                <p id="char-count">0 / 1000 words</p>
            </div>

            <div class="edit-profile-btnsection">
                <input type="submit" value="Confirm Changes" class="edit-profile-btn">
            </div>
    </form>

</div>
</div>
<script>
    document.getElementById('profile-upload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    const textarea = document.querySelector('textarea[name="bio"]');
    const wordCountDisplay = document.getElementById('char-count');

    textarea.addEventListener('input', function () {
        let length = this.value.length;
        if (length > 1000) {
            this.value = this.value.substring(0, 1000);
        }
        charCountDisplay.textContent = length + " / 1000 characters";
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>