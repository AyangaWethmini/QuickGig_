<?php require APPROOT . '/views/inc/header.php'; ?>
<?php include APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/signup.css">

<div class="signin-signup flex-row">

    <div class="image">
        <img src="<?=ROOT?>/assets/images/home.png" alt="man holding files" class="img">

        <div class="stat container flex-col">
            <img src="<?=ROOT?>/assets/icons/chart.svg" alt="stats image" width="56px" height="40px">
            <h4 class="h4-stat">100k+</h4>
            <p class="styled">People got hired</p>
        </div>

        <div class="testamonial container">
            <img src="<?=ROOT?>/assets/images/profile.png" alt="profile picture" class="profile">
            <div class="card">
                <h5 class="rev-name">Adam Slander</h5>
                <h5>Lead Engineer at Canva</h5>
                <div class=" flex-row">
                <p class="quote">"</p>
                <p class="comment">“Great platform for the job seeker that searching for new career heights.”</p>
                </div>

            </div>
        
        </div>
    </div>

    <div class="form flex-col" style="width: 450px;">

        <div class="flex-col">
        <h3 class="heading">Get more oppertunities</h3>

        <!-- Display errors -->
        <?php if (isset($_SESSION['signup_errors']) && !empty($_SESSION['signup_errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['signup_errors'] as $error): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['signup_errors']); ?>
            <?php endif; ?>
            
    <form action="<?php echo ROOT; ?>/signup/registerMore" method="POST" class="signup-form">
        <input type="hidden" name="accountID" value="<?php echo $_SESSION['accountID']; ?>">

        <select name="userType" id="userType" placeholder = "User Type" class="userType" required>
            <option value="individual" selected>Individual</option>
            <option value="organization">Organization</option>
        </select>

        <div id="individualFields">
            <div class="form-field flex-col">
                <label for="fname"  class="lbl">First Name:</label>
                <input type="text" name="fname" id="fname">
            </div>
            <div class="form-field flex-col">
                <label for="lname" class="lbl">Last Name:</label>
                <input type="text" name="lname" id="lname">
            </div>
            <div class="form-field flex-col">
                <label for="nic" class="lbl">NIC:</label>
                <input type="text" name="nic" id="nic">
            </div>
            <div class="form-field flex-col">
                <label for="gender" class="lbl">Gender:</label>
                <select name="gender"  placeholder = "Gender" class="userType" required>
                    <option value="Male" selected>Male</option>
                    <option value="Female">Female</option>
                    
                </select>
            </div>

            <div class="form-field flex-col">
                <label for="Phone" class="lbl">Contact Number:</label>
                <input type="text" name="Phone" id="Phone">
            </div>
        </div>

        <div id="organizationFields" style="display: none;">
            <div class="form-field flex-col">
                <label for="orgName" class="lbl">Organization Name:</label>
                <input type="text" name="orgName" id="orgName">
            </div>
            <div class="form-field flex-col">
                <label for="brn" class="lbl">Business Registration Number:</label>
                <input type="text" name="brn" id="brn">
            </div>
        </div>

        <button type="submit" class="btn btn-accent signup-btn" >Submit</button>
    </form>
    </div>
</div>




<?php require APPROOT . '/views/inc/footer.php'; ?>
 

<script>
const userType = document.getElementById('userType');
const individualFields = document.getElementById('individualFields');
const organizationFields = document.getElementById('organizationFields');

// Function to handle field display
function handleFieldDisplay() {
    if (userType.value === 'individual') {
        individualFields.style.display = 'block';
        organizationFields.style.display = 'none';
    } else if (userType.value === 'organization') {
        organizationFields.style.display = 'block';
        individualFields.style.display = 'none';
    }
}

// Event listener for dropdown change
userType.addEventListener('change', handleFieldDisplay);

// Initialize the form on page load with "Individual" fields
document.addEventListener('DOMContentLoaded', handleFieldDisplay);

</script>