<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/makeComplaint.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    <div class="make-complain-container">
        <div class="complain-form-container">
            <div class="employee-details">
                <p><strong>Employer Name:</strong> <?= htmlspecialchars($data['employer']->name) ?></p>
                <p><strong>Title:</strong> <?= htmlspecialchars($data['employer']->title) ?></p>
                <p><strong>Job Time:</strong> <?= htmlspecialchars($data['employer']->timeFrom) ?> - <?= htmlspecialchars($data['employer']->timeTo) ?></p>
                <p><strong>Job Date:</strong> <?= htmlspecialchars($data['employer']->availableDate) ?></p>
                <p><strong>Job/Available ID:</strong> #<?= htmlspecialchars($data['employer']->ja) ?></p>
                <p><strong>Req/Application ID:</strong> #<?= htmlspecialchars($data['employer']->applicationID ?? $data['employer']->reqID) ?></p>
            </div>
            <form id="complainForm" action="<?=ROOT?>/seeker/submitComplaint" method="post" class="complain-form">
                <input type="hidden" name="complaineeID" value="<?= htmlspecialchars($data['employer']->accountID) ?>">
                <input type="hidden" name="jobOrAvailable" value="<?= htmlspecialchars($data['employer']->ja) ?>">
                <input type="hidden" name="applicationOrReq" value="<?= htmlspecialchars($data['employer']->applicationID ?? $data['employer']->reqID) ?>">

                <div class="form-section">
                    <label for="complainInfo">Complaint Information:</label>
                    <textarea id="complainInfo" name="complainInfo" rows="10" required></textarea>
                    <p id="error-msg" style="color: red; display: none;">Complaint information cannot be empty or spaces only.</p>
                </div>
                <div class="form-section button-group">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="discard-btn" onclick="window.location.href='<?=ROOT?>/seeker/jobListing_completed';">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('complainForm').addEventListener('submit', function(event) {
        const complainInfo = document.getElementById('complainInfo').value.trim();
        const errorMsg = document.getElementById('error-msg');

        if (!complainInfo) {
            errorMsg.style.display = 'block';
            event.preventDefault(); 
        } else {
            errorMsg.style.display = 'none'; 
        }
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>