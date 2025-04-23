<?php 
require APPROOT . '/views/inc/header.php'; 
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<link rel="stylesheet" href="<?=ROOT?>/assets/css/home/advertise.css"> 

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <div class="main-content">
        <div class="ad-title flex-row">
            <h2 class="title">Advertise With Us!</h2>
        </div>
        <hr>

        <div class="ad-form flex-col">
            <div class="create-ad-form" id="create-ad">
                <form id="advertisementForm" class="equal-sections-form">
                    <!-- Advertiser Details -->
                    <div class="advertiser_details section">
                        <h4>Advertiser Details</h4>
                        <div class="field">
                            <label class="lbl">Email</label><br>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="field">
                            <label class="lbl">Advertiser Name</label><br>
                            <input type="text" id="advertiserName" name="advertiserName" required>
                        </div>
                        <div class="field">
                            <label class="lbl">Contact Number</label><br>
                            <input type="text" id="contact" name="contact" pattern="07\d{8}" title="Please enter a valid phone number (07XXXXXXXX)" required>
                        </div>
                    </div>

                    <!-- Advertisement Details -->
                    <div class="advertisement-details section">
                        <h4>Advertisement Details</h4>
                        <div class="field">
                            <label class="lbl">Title</label><br>
                            <input type="text" id="adTitle" name="adTitle" required>
                        </div>
                        <div class="field">
                            <label class="lbl">Description</label><br>
                            <textarea id="adDescription" name="adDescription" required></textarea>
                        </div>
                        <div class="field">
                            <label class="lbl">Link</label><br>
                            <input type="url" id="link" name="link" required>
                        </div>
                        <div class="field">
                            <div class="flex-row" style="gap:30px;">
                                <div>
                                    <label class="lbl">Start Date</label><br>
                                    <input type="date" id="startDate" name="startDate" required>
                                </div>
                                <div>
                                    <label class="lbl">End Date</label><br>
                                    <input type="date" id="endDate" name="endDate" required>
                                </div>
                            </div>
                        </div>
                        <div class="field radio-btns flex-row" style="gap: 30px; margin-top: 20px;">
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-paid" name="adStatus" value="1" required>
                                <label for="status-paid" class="lbl">Paid</label>
                            </div>
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-pending" name="adStatus" value="0" required>
                                <label for="status-pending" class="lbl">Payment pending</label>
                            </div>
                        </div>
                        <div id="priceEstimate" class="price-estimate" style="display: none;">
                            <p>Estimated cost: <span id="estimatedAmount">LKR 0</span> (<span id="estimatedWeeks">0</span> weeks)</p>
                        </div>
                        <div class="field img-link">
                            <label class="lbl">Advertisement Image</label><br><br>
                            <input type="file" name="adImage" accept="image/*" required onchange="previewImage(this)" class="custom-file-input">
                        </div>
                        <button class="btn btn-accent post-ad-btn" type="submit" id="submitBtn">
                            <span id="btnText">Submit Ad</span>
                            <div id="spinner" class="spinner-border spinner-border-sm d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </div>

                    <!-- Image Preview -->
                    <div class="image-preview section">
                        <h4>Image Preview</h4>
                        <div id="imagePreview">
                            <img id="preview" src="" alt="Image Preview">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            if (isset($_SESSION['success'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

document.getElementById('email').addEventListener('blur', function() {
    const email = this.value.trim();
    if(!email) return;

    fetch('<?=ROOT?>/manager/getAdvertiserByEmail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}`
    }).then(res => res.json()).then(data => {
        if(data.error){
            document.getElementById('advertiserName').value = '';
            document.getElementById('contact').value = '';
        }else{
            document.getElementById('advertiserName').value = data.advertiser.advertiserName ?? "";
            document.getElementById('contact').value = data.advertiser.contact ?? "";
        }
    }).catch(err => {
        console.error('Error:', err);    
    });
});

// Handle form submission
document.getElementById('advertisementForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const spinner = document.getElementById('spinner');
    
    // Show loading state
    submitBtn.disabled = true;
    btnText.textContent = 'Processing...';
    spinner.classList.remove('d-none');
    
    try {
        const formData = new FormData(this);
        
        // Submit to your backend
        const response = await fetch('<?=ROOT?>/manager/postAdvertisement', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        let result;
        try {
            result = await response.json();
        } catch (error) {
            throw new Error('Invalid JSON response from server');
        }
        
        if (result.status === 'payment_required') {
            // Redirect to Stripe Checkout
            window.location.href = result.redirectUrl;
        } else if (result.success) {
            // Handle successful submission without payment
            showAlert('Advertisement submitted successfully!', 'success');
            this.reset();
            document.getElementById('preview').src = '';
            document.getElementById('priceEstimate').style.display = 'none';
        } else {
            // Handle errors
            showAlert(result.error || 'An error occurred. Please try again.', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('An error occurred. Please try again.', 'error');
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        btnText.textContent = 'Submit Ad';
        spinner.classList.add('d-none');
    }
});

// Date validation and price calculation
function calculatePrice() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (!startDate || !endDate) return;
    
    const start = new Date(startDate);
    const end = new Date(endDate);
    const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
    const weeks = Math.ceil(days / 7);
    const amount = 1000 * weeks;
    
    document.getElementById('estimatedAmount').textContent = `LKR ${amount.toLocaleString()}`;
    document.getElementById('estimatedWeeks').textContent = weeks;
    document.getElementById('priceEstimate').style.display = 'block';
}

document.getElementById('endDate').addEventListener('change', function() {
    const startDate = new Date(document.getElementById('startDate').value);
    const endDate = new Date(this.value);
    
    if (startDate && endDate && startDate >= endDate) {
        showAlert('End date must be after start date', 'error');
        this.value = '';
    }
    
    if (document.getElementById('status-paid').checked) {
        calculatePrice();
    }
});

document.getElementById('startDate').addEventListener('change', function() {
    const endDate = document.getElementById('endDate').value;
    if (endDate) {
        const startDate = new Date(this.value);
        const endDateObj = new Date(endDate);
        
        if (startDate >= endDateObj) {
            showAlert('Start date must be before end date', 'error');
            document.getElementById('endDate').value = '';
        }
    }
    
    if (document.getElementById('status-paid').checked) {
        calculatePrice();
    }
});

// Radio button change handler
document.querySelectorAll('input[name="adStatus"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === '1') {
            calculatePrice();
        } else {
            document.getElementById('priceEstimate').style.display = 'none';
        }
    });
});
</script>

<style>
.price-estimate {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    margin: 10px 0;
    border: 1px solid #dee2e6;
}

.price-estimate p {
    margin: 0;
    font-weight: 500;
    color: #2c3e50;
}

.spinner-border {
    vertical-align: middle;
    margin-left: 5px;
}

.d-none {
    display: none;
}
</style>     

