<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/makeComplaint.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    <div class="make-complain-container">
        <div class="complain-form-container">
            <div class="employee-details">
                <p><strong>Employee Name:</strong> <?= htmlspecialchars($data['employee']->fname . ' ' . $data['employee']->lname) ?></p>
                <p><strong>Title:</strong> <?= htmlspecialchars($data['employee']->title)?></p>
                <p><strong>Job Time:</strong> <?= htmlspecialchars($data['employee']->timeFrom) ?> - <?= htmlspecialchars($data['employee']->timeTo) ?></p>
                <p><strong>Job Date:</strong> <?= htmlspecialchars($data['employee']->availableDate) ?></p>
                <p><strong>Job/Available ID:</strong> #<?= htmlspecialchars($data['employee']->ja) ?></p>
                <p><strong>Req/Application ID:</strong> #<?= htmlspecialchars($data['employee']->applicationID ?? $data['employee']->reqID) ?></p>
            </div>
            <form id="complainForm" action="<?=ROOT?>/organization/submitComplaint" method="post" class="complain-form">
                <input type="hidden" name="complaineeID" value="<?= htmlspecialchars($data['employee']->accountID) ?>">
                <input type="hidden" name="jobOrAvailable" value="<?= htmlspecialchars($data['employee']->ja) ?>">
                <input type="hidden" name="applicationOrReq" value="<?= htmlspecialchars($data['employee']->applicationID ?? $data['employee']->reqID) ?>">

                <div class="form-section">
                    <label for="complainInfo">Complaint Information:</label>
                    <textarea id="complainInfo" name="complainInfo" rows="10" required></textarea>
                    <p id="error-msg" style="color: red; display: none;">Complaint information cannot be empty or spaces only.</p>
                </div>
                <div class="form-section button-group">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="discard-btn" onclick="window.location.href='<?=ROOT?>/organization/org_jobListing_completed';">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add event listener to validate the form before submission
    document.getElementById('complainForm').addEventListener('submit', function(event) {
        const complainInfo = document.getElementById('complainInfo').value.trim();
        const errorMsg = document.getElementById('error-msg');

        // Check if the complainInfo is empty or only contains spaces
        if (!complainInfo) {
            errorMsg.style.display = 'block';
            event.preventDefault(); // Prevent form submission
        } else {
            errorMsg.style.display = 'none'; // Hide error message
        }
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>