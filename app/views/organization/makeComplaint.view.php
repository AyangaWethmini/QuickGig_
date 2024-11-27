<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/makeComplaint.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    <div class="make-complain-container">
        <div class="complain-form-container">
            <div class="employee-details">
                <p><strong>Employee Name:</strong> Kane Smith</p>
                <p><strong>Job:</strong> Plumber</p>
                <p><strong>Job Start Time:</strong> 03:00 PM</p>
                <p><strong>Job End Time:</strong> 05:00 PM</p>
                <p><strong>Job Date:</strong> 2023-10-01</p>
                <p><strong>Job Location:</strong> Manchester, UK</p>
            </div>
            <form id="complainForm" action="<?=ROOT?>/jobProvider/submitComplaint" method="post" class="complain-form">               
                <div class="form-section">
                    <label for="complainInfo">Complain Information:</label>
                    <textarea id="complainInfo" name="complainInfo" rows="10" required></textarea>
                    <p id="error-msg" style="color: red; display: none;">Complaint information cannot be empty or spaces only.</p>
                </div>
                <div class="form-section button-group">
                    <button type="submit" class="submit-btn">Submit</button>
                    <button type="button" class="discard-btn" onclick="window.location.href='<?=ROOT?>/organization/jobListing_completed';">Discard</button>
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
