<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/makeComplaint.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="make-complain-container">
        <div class="complain-form-container">
            <form id="updateComplaintForm" action="<?=ROOT?>/jobProvider/updateComplaint/<?= $data['complaint']->complaintID ?>" method="post" class="complain-form">               
                <div class="form-section">
                    <label for="complainInfo">Complain Information:</label>
                    <textarea id="complainInfo" name="complainInfo" rows="10" required><?= $data['complaint']->content ?></textarea>
                    <p id="error-msg" style="color: red; display: none;">Complaint information cannot be empty or spaces only.</p>
                </div>
                <div class="form-section button-group">
                    <button type="submit" class="submit-btn">Update</button>
                    <button type="button" class="discard-btn" onclick="window.location.href='<?=ROOT?>/jobProvider/complaints';">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('updateComplaintForm').addEventListener('submit', function(event) {
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
