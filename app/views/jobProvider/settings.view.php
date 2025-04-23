<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/settings.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>

    <div class="main-content-settings">
        <div class="header">
            <div class="heading">Settings</div>
        </div>
        <hr>

        <div class="actions">
            <div class="card" onclick="openPopup('changePwPopup')">
                <p class="lbl">Change Password</p>
            </div>
            <div class="card" onclick="openPopup('deactivateAccountPopup')">
                <p class="lbl">Deactivate Account</p>
            </div>
            <div class="card" onclick="openPopup('deleteAccountPopup')">
                <p class="lbl">Delete Account</p>
            </div>
        </div>

        <!-- Success Message Popup for Password Change -->
        <div class="popup-overlay hidden" id="successPopup">
            <div class="popup-form success-popup">
                <div class="success-icon">✓</div>
                <h2>Success!</h2>
                <p>Password updated successfully!</p>
                <div class="popup-btns">
                    <button type="button" class="btn btn-accent" onclick="closePopup('successPopup')">OK</button>
                </div>
            </div>
        </div>

        <!-- Success Message Popup for Deactivate Account -->
        <div class="popup-overlay hidden" id="deactivateSuccessPopup">
            <div class="popup-form success-popup">
                <div class="success-icon">✓</div>
                <h2>Success!</h2>
                <p>Your account has been deactivated successfully!</p>
                <p class="sub-text">You will be redirected to the login page in a few seconds.</p>
                <div class="popup-btns">
                    <button type="button" class="btn btn-accent" onclick="redirectToLogin()">OK</button>
                </div>
            </div>
        </div>

        <!-- Change Password Popup -->
        <div class="popup-overlay hidden" id="changePwPopup">
            <div class="popup-form">
                <h1>Change Password</h1>
                <form id="changePasswordForm">
                    <div class="form-field">
                        <label for="oldpw">
                            <p class="lbl">Enter old password:</p>
                        </label>
                        <input type="password" id="oldpw" name="oldpw" placeholder="Old password" required>
                        <p class="error-text" id="oldPasswordError"></p>
                    </div>
                    <div class="form-field">
                        <label for="newpw">
                            <p class="lbl">Enter new password:</p>
                        </label>
                        <input type="password" id="newpw" name="newpw" placeholder="New password" required>
                        <p class="error-text" id="newPasswordError"></p>
                    </div>
                    <div class="form-field">
                        <label for="renewpw">
                            <p class="lbl">Re-enter password:</p>
                        </label>
                        <input type="password" id="renewpw" name="renewpw" placeholder="Re-enter new password" required>
                    </div>
                    <div class="popup-btns">
                        <button type="button" class="btn btn-del" onclick="closePopup('changePwPopup')">Cancel</button>
                        <button type="submit" class="btn btn-accent">Update Password</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Deactivate Account Popup -->
        <div class="popup-overlay hidden" id="deactivateAccountPopup">
            <div class="popup-form">
                <h1>Deactivate Account</h1>
                <form id="deactivateAccountForm">
                    <div class="info-text">
                        <p>Your account will be deactivated immediately. You can reactivate it anytime by logging back in.</p>
                        <p>While deactivated, your profile will not be visible to other users and you won't receive any notifications.</p>
                    </div>
                    <div class="form-field checkbox-field">
                        <input type="checkbox" id="confirmDeactivate" name="confirm" required>
                        <label for="confirmDeactivate" class="lbl">I understand that my account will be deactivated.</label>
                    </div>
                    <p class="error-text" id="deactivateError"></p>
                    <div class="popup-btns">
                        <button type="button" class="btn btn-del" onclick="closePopup('deactivateAccountPopup')">Cancel</button>
                        <button type="submit" class="btn btn-accent">Confirm Deactivation</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Popup -->
        <div class="popup-overlay hidden" id="deleteAccountPopup">
            <div class="popup-form">
                <h1>Delete Account</h1>
                <form id="deleteAccountForm">
                    <p class="warning-text">Warning: This action cannot be undone. All your data will be permanently deleted.</p>
                    <div class="form-field">
                        <label for="deleteEmail">
                            <p class="lbl">Enter your email:</p>
                        </label>
                        <input type="email" id="deleteEmail" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-field">
                        <label for="deletePassword">
                            <p class="lbl">Enter your password:</p>
                        </label>
                        <input type="password" id="deletePassword" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-field">
                        <label for="confirmDelete">
                            <p class="lbl">Type "Delete my account":</p>
                        </label>
                        <input type="text" id="confirmDelete" name="confirmText" placeholder="Delete my account" required>
                    </div>
                    <div class="form-field checkbox-field">
                        <input type="checkbox" id="confirmCheckbox" name="confirm" required>
                        <label for="confirmCheckbox" class="lbl">I understand this action cannot be undone. All data will be erased.</label>
                    </div>
                    <p class="error-text" id="deleteError"></p>
                    <div class="popup-btns">
                        <button type="button" class="btn btn-del" onclick="closePopup('deleteAccountPopup')">Cancel</button>
                        <button type="submit" class="btn btn-accent">Delete My Account</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Confirmation Popup for Delete Account -->
        <div class="popup-overlay hidden" id="confirmDeletePopup">
            <div class="popup-form warning-popup">
                <div class="warning-icon">!</div>
                <h2>Are you sure?</h2>
                <p>This will permanently delete your account and all associated data. This action cannot be undone.</p>
                <div class="popup-btns">
                    <button type="button" class="btn btn-del" onclick="closePopup('confirmDeletePopup')">Cancel</button>
                    <button type="button" class="btn btn-accent" onclick="confirmDeleteAccount()">Yes, Delete My Account</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Backdrop to disable interaction with other elements -->
<div class="backdrop hidden" id="backdrop"></div>

<style>
    .error-text {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
        display: none;
    }

    .info-text {
        color: #31708f;
        background-color: #d9edf7;
        border: 1px solid #bce8f1;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .warning-text {
        color: #8a6d3b;
        background-color: #fcf8e3;
        border: 1px solid #faebcc;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .sub-text {
        font-size: 0.9em;
        color: #666;
        margin-top: -10px;
    }

    .success-popup,
    .warning-popup {
        text-align: center;
        max-width: 400px;
        padding: 30px;
    }

    .success-icon {
        background-color: #4CAF50;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        line-height: 60px;
        font-size: 30px;
        margin: 0 auto 15px;
    }

    .warning-icon {
        background-color: #f0ad4e;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        line-height: 60px;
        font-size: 36px;
        margin: 0 auto 15px;
    }

    .success-popup h2 {
        color: #4CAF50;
        margin-bottom: 15px;
    }

    .warning-popup h2 {
        color: #f0ad4e;
        margin-bottom: 15px;
    }

    .success-popup p,
    .warning-popup p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    .success-popup .btn,
    .warning-popup .btn {
        min-width: 100px;
    }

    .checkbox-field {
        display: flex;
        align-items: flex-start;
    }

    .checkbox-field input {
        margin-top: 3px;
        margin-right: 10px;
    }

    .hidden {
        display: none;
    }
</style>

<script>
    function openPopup(popupId) {
        const popup = document.getElementById(popupId);
        const backdrop = document.getElementById('backdrop');
        popup.classList.remove('hidden');
        popup.classList.add('show');
        backdrop.classList.remove('hidden');
    }

    function closePopup(popupId) {
        const popup = document.getElementById(popupId);
        const backdrop = document.getElementById('backdrop');
        popup.classList.remove('show');
        popup.classList.add('hidden');
        backdrop.classList.add('hidden');
    }

    function redirectToLogin() {
        window.location.href = '<?= ROOT ?>/home/login';
    }

    // Change Password Form Submission
    document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        fetch('<?= ROOT ?>/jobProvider/changePassword', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Clear previous error messages
                document.getElementById('oldPasswordError').style.display = 'none';
                document.getElementById('newPasswordError').style.display = 'none';

                if (data.success) {
                    // Reset form fields
                    document.getElementById('changePasswordForm').reset();

                    // Close the change password popup
                    closePopup('changePwPopup');

                    // Show success popup
                    openPopup('successPopup');
                } else {
                    if (data.errors.oldPassword) {
                        document.getElementById('oldPasswordError').textContent = data.errors.oldPassword;
                        document.getElementById('oldPasswordError').style.display = 'block';
                    }
                    if (data.errors.newPassword) {
                        document.getElementById('newPasswordError').textContent = data.errors.newPassword;
                        document.getElementById('newPasswordError').style.display = 'block';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Delete Account Form Submission
    document.getElementById('deleteAccountForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Validate form data
        const confirmText = document.getElementById('confirmDelete').value;
        const confirmCheckbox = document.getElementById('confirmCheckbox').checked;

        if (confirmText !== 'Delete my account') {
            document.getElementById('deleteError').textContent = 'Please type "Delete my account" exactly as shown.';
            document.getElementById('deleteError').style.display = 'block';
            return;
        }

        if (!confirmCheckbox) {
            document.getElementById('deleteError').textContent = 'Please confirm that you understand the consequences of this action.';
            document.getElementById('deleteError').style.display = 'block';
            return;
        }

        // Show confirmation popup
        closePopup('deleteAccountPopup');
        openPopup('confirmDeletePopup');
    });

    function confirmDeleteAccount() {
        const formData = new FormData(document.getElementById('deleteAccountForm'));

        fetch('<?= ROOT ?>/jobProvider/deleteAccount', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Add this to ensure server detects AJAX
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success - redirect to login page
                    window.location.href = '<?= ROOT ?>/home/login';
                } else {
                    // Error - display the error message
                    closePopup('confirmDeletePopup');
                    openPopup('deleteAccountPopup');

                    // Display the error message
                    document.getElementById('deleteError').textContent = data.message || 'An error occurred while deleting your account.';
                    document.getElementById('deleteError').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                closePopup('confirmDeletePopup');
                openPopup('deleteAccountPopup');
                document.getElementById('deleteError').textContent = 'An error occurred while deleting your account.';
                document.getElementById('deleteError').style.display = 'block';
            });
    }

    // Deactivate Account Form Submission
    document.getElementById('deactivateAccountForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Check if the confirmation checkbox is checked
        const confirmDeactivate = document.getElementById('confirmDeactivate').checked;

        if (!confirmDeactivate) {
            document.getElementById('deactivateError').textContent = 'Please confirm that you understand your account will be deactivated.';
            document.getElementById('deactivateError').style.display = 'block';
            return;
        }

        // Clear any previous error messages
        document.getElementById('deactivateError').style.display = 'none';

        const formData = new FormData();
        formData.append('confirm', 'true');

        // Log the form submission
        console.log('Submitting deactivation request...');

        fetch('<?= ROOT ?>/jobProvider/deactivateAccount', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Add this to ensure the server detects AJAX request
                }
            })
            .then(response => {
                console.log('Server response:', response);
                // Check if the response is ok (status in the range 200-299)
                if (response.ok) {
                    // Try to parse as JSON, but don't fail if it's not JSON
                    return response.json().catch(() => ({
                        success: true
                    }));
                } else {
                    // If status is not ok, throw an error to be caught by the catch block
                    throw new Error('Server responded with status: ' + response.status);
                }
            })
            .then(data => {
                console.log('Response data:', data);
                // Reset form fields
                document.getElementById('deactivateAccountForm').reset();

                // Close the deactivate account popup
                closePopup('deactivateAccountPopup');

                // Show success popup
                openPopup('deactivateSuccessPopup');

                // After a delay, redirect to login page
                setTimeout(function() {
                    window.location.href = '<?= ROOT ?>/home/login';
                }, 3000);
            })
            .catch(error => {
                console.error('Error details:', error.message);
                document.getElementById('deactivateError').textContent = 'An error occurred: ' + error.message;
                document.getElementById('deactivateError').style.display = 'block';
            });
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>