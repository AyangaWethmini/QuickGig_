<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([3]); ?>
<?php include APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/editprofile.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    <form action="<?= ROOT ?>/organization/updateProfile" method="POST" enctype="multipart/form-data">
        <div class="user-editprofile">
            <div class="editprofile-section 1">
                <div class="section1-left">
                    <h2>Profile Photo</h2>
                    <p style="color:white;">This image will be shown publicly as your
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
                    <input type="text" name="orgName" class="custom-input part2" placeholder="Farming Company" value="<?= htmlspecialchars(($data['orgName'] ?? '')) ?>"><br><br>

                    <label><strong>Location</strong></label><br>
                    <input type="text" name="addressLine1" class="custom-input part3" placeholder="Address Line 1" value="<?= htmlspecialchars(($data['addressLine1'] ?? '')) ?>"><br><br>
                    <input type="text" name="addressLine2" class="custom-input part3" placeholder="Address Line 2" value="<?= htmlspecialchars(($data['addressLine2'] ?? '')) ?>"><br><br>
                    <input type="text" name="city" class="custom-input part3" placeholder="City" value="<?= htmlspecialchars(($data['city'] ?? '')) ?>"><br><br>
                    <label><strong>District</strong></label><br>
                    <input type="text" name="district" class="custom-input part3" placeholder="District" value="<?= htmlspecialchars(($data['district'] ?? '')) ?>"><br><br>
                    <div class="phone-container">
                        <select name="countryCode" id="countryCode2" class="country-code">
                            <option value="<?= htmlspecialchars($data['countryCode'] ?? '') ?>" selected><?= htmlspecialchars($data['countryCode'] ?? 'Select your country code') ?></option>
                        </select>
                        <input type="text" name="Phone" id="Phone2" placeholder="7700000000" value="<?= htmlspecialchars(($data['phoneDig'] ?? '')) ?>">
                    </div>
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
                </div>
            </div>
            <br>
            <hr><br>

            <div class="edit-profile-description">
                <h2>Description</h2>
                <textarea name="bio" class="custom-input part4"
                    placeholder="Your description here"
                    maxlength="6000"><?= htmlspecialchars(($data['bio'] ?? '')) ?></textarea>

                <p id="char-count">0 / 1000 characters</p>
            </div>

            <div class="edit-profile-btnsection">
                <input type="submit" value="Confirm Changes" class="edit-profile-btn">
            </div>

        </div>
    </form>
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
    const charCountDisplay = document.getElementById('char-count');

    textarea.addEventListener('input', function() {
        let length = this.value.length;
        if (length > 1000) {
            this.value = this.value.substring(0, 1000);
        }
        charCountDisplay.textContent = length + " / 1000 characters";
    });
</script>
<script>
    // Fetch country codes and fill the select dropdown
    fetch('https://restcountries.com/v3.1/all')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('countryCode2');

            if (!select) {
                console.error('countryCode2 select element not found');
                return;
            }

            // Sort countries alphabetically
            data.sort((a, b) => {
                const nameA = a.name.common.toUpperCase();
                const nameB = b.name.common.toUpperCase();
                return nameA.localeCompare(nameB);
            });

            // Loop and add options
            data.forEach(country => {
                const countryName = country.name.common;
                let countryCode = '';

                if (country.idd && Array.isArray(country.idd.suffixes) && country.idd.suffixes.length > 0) {
                    countryCode = country.idd.root + country.idd.suffixes[0];
                }

                if (countryCode) {
                    const option = document.createElement('option');
                    option.value = countryCode;
                    option.textContent = `${countryCode} (${countryName})`;
                    select.appendChild(option);
                }
            });

            // OPTIONAL: Set default selected country code to Sri Lanka (+94)
            select.value = '+94';
        })
        .catch(error => {
            console.error('Error fetching country data:', error);
        });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>