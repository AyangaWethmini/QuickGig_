<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/makeComplaint.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="make-complain-container">
        <div class="complain-form-container">
            <form action="<?=ROOT?>/jobProvider/updateComplaint/<?= $data['complaint']->complaintID ?>" method="post" class="complain-form">               
                <div class="form-section">
                    <label for="complainInfo">Complain Information:</label>
                    <textarea id="complainInfo" name="complainInfo" rows="10" required><?= $data['complaint']->content ?></textarea>
                </div>
                <div class="form-section button-group">
                    <button type="submit" class="submit-btn">Update</button>
                    <button type="button" class="discard-btn" onclick="window.location.href='<?=ROOT?>/jobProvider/complaints';">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>