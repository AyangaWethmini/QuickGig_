<?php require APPROOT . '/views/inc/header.php';
require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]);
?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1 style="font-size: 2.5rem;"><strong>Current Announcements</strong></h1>

            <a href="<?php echo ROOT; ?>/admin/createannouncement">
                <button class="btn btn-accent srch-btn">+ Post Announcement</button>
            </a>
        </div>
        <br>
        <hr>

        <div class="complaints-container container">
            <?php if (empty($data['announcements'])): ?>
                <div class="no-results">
                    No announcements found.
                </div>
            <?php else: ?>
                <?php foreach ($data['announcements'] as $announcement): ?>
                    <div class="complaint container">
                        <div class="complaint-content flex-col">
                            <div class="complaint-details flex-row">
                                <div class="complaint-text flex-col">
                                    <div class="the-complaint" style="font-size: 1.8rem;"><?php echo $announcement->content; ?></div>
                                    <div class="text-grey" style="font-size: 1.2rem;">
                                        <?php
                                        $formattedTime = date('h:i A', strtotime($announcement->announcementTime));
                                        echo $announcement->announcementDate . ' | ' . $formattedTime;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="complaint-actions flex-row">
                                <a href="<?php echo ROOT; ?>/admin/admineditannouncement/<?php echo $announcement->announcementID; ?>">
                                    <button class="btn btn-update">Update</button>
                                </a>
                                <button class="btn btn-delete" onclick="confirmDelete(<?php echo $announcement->announcementID ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="pagination-container">
            <div class="pagination">
                <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= max(1, ($data['currentPage'] ?? 1) - 1) ?>"
                    class="page-link <?= ($data['currentPage'] ?? 1) <= 1 ? 'disabled' : '' ?>">
                    &laquo;
                </a>

                <?php for ($i = 1; $i <= max(1, $data['totalPages'] ?? 1); $i++): ?>
                    <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= $i ?>"
                        class="page-link <?= $i == ($data['currentPage'] ?? 1) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= min($data['totalPages'] ?? 1, ($data['currentPage'] ?? 1) + 1) ?>"
                    class="page-link <?= ($data['currentPage'] ?? 1) >= ($data['totalPages'] ?? 1) ? 'disabled' : '' ?>">
                    &raquo;
                </a>
            </div>
            <div class="pagination-info">
                (Total announcements: <?= $data['totalAnnouncements'] ?? 0 ?>)
            </div>
        </div>
    </div>
</div>
<div id="delete-confirmation" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this announcement?</p>
        <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
        <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;"></form>

<script>
    function confirmDelete(id) {
        var modal = document.getElementById('delete-confirmation');
        modal.style.display = 'flex';

        document.getElementById('confirm-yes').onclick = function() {
            var form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/admin/deleteAnnouncement/' + id;
            modal.style.display = 'none';

            form.submit();
        };

        document.getElementById('confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>

<style>
    .admin-container {
        position: relative;
        min-height: 600px;
        padding-bottom: 100px;
    }

    .complaints-container {
        flex: 1;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 60px;
        width: 90%;
    }

    .btn-accent.srch-btn {
        width: 300px;
        height: 50px;
        font-size: 1.2rem;
        padding: 10px 15px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-accent.srch-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .pagination-container {
        position: absolute;
        bottom: 110px;
        left: 0;
        right: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
        padding: 15px 0;
        margin: 0;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        min-width: 300px;
    }

    .page-link {
        padding: 8px 16px;
        min-width: 40px;
        text-align: center;
        border: 1px solid rgb(198, 198, 249);
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .page-link.disabled {
        opacity: 0.5;
        pointer-events: none;
        background-color: #f0f0f0;
    }

    .page-link:hover:not(.disabled) {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    .page-link.active {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    .pagination-info {
        color: #666;
        font-size: 0.9em;
    }

    .complaint.container {
        margin: 0;
        width: 100%;
    }

    .complaint-content {
        position: relative;
        min-height: 120px;
        padding-bottom: 30px;
    }

    .complaint-text {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .text-grey {
        position: absolute;
        bottom: 10px;
        left: 10px;
        margin-top: auto;
        text-align: left;
    }

    .no-results {
        text-align: center;
        padding: 30px;
        color: #666;
        font-size: 16px;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin: 20px 0;
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>