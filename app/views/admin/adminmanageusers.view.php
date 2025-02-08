<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Active Users</h1>
        </div>
        <br>
        <hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Advertisements">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Users</h1>
        </div>
        <div class="complaints-container container">
            <?php foreach ($data['users'] as $user): ?>
                <?php if ($user->roleID != 0 && $user->roleID != 1): ?>
                    <div class="complaint container" style="border: 2px solid <?php echo $user->activationCode ? 'green' : 'red'; ?>;">
                        <div class="complaint-details flex-col">
                            <div class="complaint-details flex-row">
                                <div class="the-complaint">
                                    <strong>Account ID:</strong> <?php echo $user->accountID; ?><br>
                                    <strong>Email:</strong> <?php echo $user->email; ?><br>
                                    <strong>Role:</strong>
                                    <?php
                                    if ($user->roleID == 2) {
                                        echo 'Individual';
                                    } elseif ($user->roleID == 3) {
                                        echo 'Organization';
                                    } else {
                                        echo 'Unknown';
                                    }
                                    ?><br>
                                </div>
                                <div>
                                    <button class="btn btn-delete" onclick="confirmDelete('<?php echo $user->accountID; ?>')">Delete</button>

                                    <a href="<?php echo ROOT; ?>/admin/deactivateUser/<?php echo $user->accountID; ?>">
                                        <button style="background-color:brown;" class="btn btn-update">Deactivate</button>
                                    </a>

                                    <a href="<?php echo ROOT; ?>/admin/activateUser/<?php echo $user->accountID; ?>">
                                        <button style="background-color:green;" class="btn btn-update">Activate</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-confirmation" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this user? This action is irreversible.</p>
        <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
        <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;"></form>

<script>
    function confirmDelete(accountID) {
        var modal = document.getElementById('delete-confirmation');
        modal.style.display = 'flex';

        document.getElementById('confirm-yes').onclick = function() {
            var form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/admin/deleteUser';
            form.innerHTML = '<input type="hidden" name="accountID" value="' + accountID + '">';
            modal.style.display = 'none';

            form.submit();
        };

        document.getElementById('confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('delete-confirmation');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>