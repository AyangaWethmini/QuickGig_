<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/complaints.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing_myJobs.css">


<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>

    <div class="main-content-complaints">
        <div class="header">
            <div class="heading">My Complaints</div>
        </div>

        <div class="complaints-container container">
            <?php if (empty($data['complaints'])): ?>
                <div class="empty-container">
                    <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Complaints" class="empty-icon">
                    <p class="empty-text">No Complaints Have Been Made Yet</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['complaints'] as $complaint): ?>
                    <div class="complaint container" style="background: linear-gradient(135deg, #e0f0ff, #f0e8ff);">
                        <div class="complaint-content flex-col">
                            <div class="complaint-details flex-row">
                                <div class="complaint-text flex-col">
                                    <div class="the-complaint" style="font-size: 20px;"><?= htmlspecialchars($complaint->content, ENT_QUOTES) ?></div>
                                    <div class="text-grey" style="font-size: 16px;">
                                        <?= htmlspecialchars($complaint->complaintDate . ' | ' . date('h:i:s', strtotime($complaint->complaintTime)), ENT_QUOTES) ?>
                                    </div>
                                </div>
                                <div class="complaint-status">
                                    <?php
                                    if ($complaint->complaintStatus == 1) {
                                        echo 'Pending';
                                    } elseif ($complaint->complaintStatus == 2) {
                                        echo 'Dismissed';
                                    } elseif ($complaint->complaintStatus == 3) {
                                        echo 'Reviewed';
                                    } else {
                                        echo 'Unknown Status';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="complaint-actions flex-row">
                                <button
                                    class="update-jobReq-button btn btn-accent <?= $complaint->complaintStatus != 1 ? 'disabled-btn' : '' ?>"
                                    <?= $complaint->complaintStatus != 1 ? 'disabled' : '' ?>
                                    onClick="window.location.href='<?= ROOT ?>/seeker/updateComplaint/<?= $complaint->complaintID ?>';">
                                    Update
                                </button>
                                <button
                                    class="delete-jobReq-button btn btn-danger <?= $complaint->complaintStatus != 1 ? 'disabled-btn' : '' ?>"
                                    <?= $complaint->complaintStatus != 1 ? 'disabled' : '' ?>
                                    onclick="showDeletePopup('<?= htmlspecialchars($complaint->complaintID, ENT_QUOTES) ?>')">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="delete-popup" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this complaint?</p>
        <button id="delete-confirm-yes" class="popup-btn-delete-complaint">Yes</button>
        <button id="delete-confirm-no" class="popup-btn-delete-complaint">No</button>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;"></form>

<script>
    function showDeletePopup(complaintID) {
        const modal = document.getElementById('delete-popup');
        modal.style.display = 'flex';

        document.getElementById('delete-confirm-yes').onclick = function() {
            const form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/seeker/deleteComplaint/' + complaintID;
            modal.style.display = 'none';
            form.submit();
        };

        document.getElementById('delete-confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>