<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/makeComplaint.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    <div class="make-complain-container">
        <div class="complain-form-container">
            <div class="employee-details">
                <p><strong>Employer Name:</strong> Kane Smith</p>
                <p><strong>Job:</strong> Gardner</p>
                <p><strong>Job Start Time:</strong> 03:00 PM</p>
                <p><strong>Job End Time:</strong> 05:00 PM</p>
                <p><strong>Job Date:</strong> 2023-10-01</p>
                <p><strong>Job Location:</strong> Manchester, UK</p>
            </div>
            <form action="<?=ROOT?>/jobProvider/submitComplaint" method="post" class="complain-form">               
                <div class="form-section">
                    <label for="complainInfo">Complain Information:</label>
                    <textarea id="complainInfo" name="complainInfo" rows="10" required></textarea>
                </div>
                <div class="form-section button-group">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="discard-btn" onclick="window.location.href='<?=ROOT?>/seeker/jobListing_completed';">Discard</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>