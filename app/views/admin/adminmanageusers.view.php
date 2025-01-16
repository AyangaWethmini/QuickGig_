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
                <?php if ($user->roleID != 0): ?>
                    <div class="complaint container">
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
                                    }
                                    ?><br>
                                </div>

                                <div>
                                    <form action="<?= ROOT ?>/admin/deleteUser" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="accountID" value="<?= $user->accountID ?>">
                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>