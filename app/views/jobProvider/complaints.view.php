<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/complaints.css">

<body>
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>

        <div class="main-content-complaints">
            <div class="header">
                <div class="heading">My Complaints</div>
            </div>
            
            <div class="search-container">
                <input type="text"
                    class="search-bar"
                    placeholder="Search complaints"
                    aria-label="Search">
                <br><br>
                
            </div>
            <div class="complaints-container container">
                <?php if (empty($data['complaints'])): ?>
                    <div class="empty-container">
                        <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Complaints" class="empty-icon">
                        <p class="empty-text">No Complaints Have Been Made Yet</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($data['complaints'] as $complaint): ?>
                        <div class="complaint container">
                            <div class="complaint-content flex-col">
                                <div class="complaint-details flex-row">
                                    <div class="complaint-text flex-col">
                                        <div class="the-complaint"><?php echo htmlspecialchars($complaint->content, ENT_QUOTES); ?></div>
                                        <div class="text-grey">
                                            <?php
                                            $formattedTime = date('h:i:s', strtotime($complaint->complaintTime));
                                            echo htmlspecialchars($complaint->complaintDate . ' | ' . $formattedTime, ENT_QUOTES);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="complaint-status">
                                        <?php
                                        if ($complaint->complaintStatus == 1) {
                                            echo htmlspecialchars('Pending', ENT_QUOTES);
                                        } elseif ($complaint->complaintStatus == 2) {
                                            echo htmlspecialchars('Dismissed', ENT_QUOTES);
                                        } elseif ($complaint->complaintStatus == 3) {
                                            echo htmlspecialchars('Reviewed', ENT_QUOTES);
                                        } else {
                                            echo htmlspecialchars('Unknown Status', ENT_QUOTES);
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="complaint-actions flex-row">
                                    <button
                                        class="btn btn-update <?= $complaint->complaintStatus != 1 ? 'disabled-btn' : '' ?>"
                                        <?= $complaint->complaintStatus != 1 ? 'disabled' : '' ?>
                                        onClick="window.location.href='<?= ROOT ?>/jobProvider/updateComplaint/<?= $complaint->complaintID ?>';">
                                        Update
                                    </button>
                                    <button
                                        class="btn btn-delete <?= $complaint->complaintStatus != 1 ? 'disabled-btn' : '' ?>"
                                        <?= $complaint->complaintStatus != 1 ? 'disabled' : '' ?>
                                        onclick="showDeletePopup('<?php echo htmlspecialchars($complaint->complaintID, ENT_QUOTES) ?>')">
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
</body>
<script>
    function showDeletePopup(complaintID) {
        const modal = document.getElementById('delete-popup');
        modal.style.display = 'flex';

        document.getElementById('delete-confirm-yes').onclick = function() {
            const form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/jobProvider/deleteComplaint/' + complaintID;
            modal.style.display = 'none';
            form.submit();
        };

        document.getElementById('delete-confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>