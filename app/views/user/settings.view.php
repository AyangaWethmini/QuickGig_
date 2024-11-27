<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/settings.css">

<div class="settings container">
    <div class="header flex-row">
        <i class="fa-solid fa-arrow-left"></i>
        <h3>Settings</h3>
    </div>
    <hr>


    <div class="actions">
        <a href="#" onclick="openPopup('changePwPopup')"><p class="lbl">Change Password</p></a>
        <hr>
        <a href="#" onclick="openPopup('deactivateAccountPopup')"><p class="lbl">Deactivate Account</p></a>
        <hr>
        <a href="#" onclick="openPopup('deleteAccountPopup')"><p class="lbl">Delete Account</p></a>
    </div>

    <!-- Change Password Popup -->
    <div class="popup-overlay hidden" id="changePwPopup">
        <div class="popup-form">
            <h1>Change Password</h1>
            <form action="">
                <div class="form-field">
                    <label for="oldpw"><p class="lbl">Enter old password:</p></label>
                    <input type="password" id="oldpw" placeholder="Old password">
                </div>
                <div class="form-field">
                    <label for="newpw"><p class="lbl">Enter new password:</p></label>
                    <input type="password" id="newpw" placeholder="New password">
                </div>
                <div class="form-field">
                    <label for="renewpw"><p class="lbl">Re-enter password:</p></label>
                    <input type="password" id="renewpw" placeholder="Re-enter new password">
                </div>
                <div class="popup-btns">
                    <button type="button" class="btn btn-del" onclick="closePopup('changePwPopup')">Cancel</button>
                    <button class="btn btn-accent">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Deactivate Account Popup -->
    <div class="popup-overlay hidden" id="deactivateAccountPopup">
        <div class="popup-form">
            <h1>Deactivate Account</h1>
            <form action="">
                <p class="lbl">You can always reactivate your account by logging back in.</p>
                <div class="form-field">
                    <label for="duration"><p class="lbl">Choose Deactivation Period:</p></label>
                    <select name="duration" id="duration">
                        <option value="15_days">15 Days</option>
                        <option value="1_month">1 Month</option>
                        <option value="3_months">3 Months</option>
                        <option value="1_year">1 Year</option>
                    </select>
                </div>

                <div class="popup-btns">
                    <button type="button" class="btn btn-del" onclick="closePopup('deactivateAccountPopup')">Cancel</button>
                    <button class="btn btn-accent">Confirm Deactivation</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Popup -->
    <div class="popup-overlay hidden" id="deleteAccountPopup">
        <div class="popup-form">
            <h1>Delete Account</h1>
            <form action="">
                <div class="form-field">
                    <label for="email"><p class="lbl">Enter your email:</p></label>
                    <input type="email" id="email" placeholder="Email Address">
                </div>
                <div class="form-field">
                    <label for="password"><p class="lbl">Enter your password:</p></label>
                    <input type="password" id="password" placeholder="Password">
                </div>
                <div class="form-field">
                    <label for="confirmDelete"><p class="lbl">Type "Delete my account":</p></label>
                    <input type="text" id="confirmDelete" placeholder="Delete my account">
                </div>
                <div class="form-field">
                    <input type="checkbox" id="confirmCheckbox">
                    <label for="confirmCheckbox" class="lbl">I understand this action cannot be undone. All data will be erased.</label>
                </div>
                <div class="popup-btns">
                    <button type="button" class="btn btn-del" onclick="closePopup('deleteAccountPopup')">Cancel</button>
                    <button type="submit" class="btn btn-accent">Delete My Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Backdrop to disable interaction with other elements -->
<div class="backdrop hidden" id="backdrop"></div>

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
</script>
