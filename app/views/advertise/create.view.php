<?php
require APPROOT . '/views/inc/header.php';
?>


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

   
    .wrapper {
        background: linear-gradient(180deg, var(--brand-primary) 0%, #f8fbff 100%);
        min-height: 100vh;
        padding-top: 20px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .main-content {
        font-family: 'Poppins';
        background: #ffffff;
        /* padding: 40px; */
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);

    }

    .wrapper h2 {
        font-size: 32px;
        color: rgb(255, 255, 255);
        font-weight: 700;
        margin-bottom: 20px;
    }

  
    .ad-title .title {
        font-size: 36px;
        color: #2d2f48;
        font-weight: 700;
    }

    .text-grey {
        color: #6c757d;
        font-size: 18px;
    }

    .section h4 {
        font-size: 22px;
        color: #2d2f48;
        font-weight: 700;
        margin-bottom: 20px;
        border-left: 4px solid #4e54c8;
        padding-left: 10px;
    }

    input[type="text"],
    input[type="email"],
    input[type="url"],
    input[type="date"],
    textarea {
        background-color: #f9fbfd;
        border: 1px solid #d1d9e6;
        border-radius: 8px;
        padding: 10px 14px !important;
        font-size: 16px;
        transition: 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="url"]:focus,
    input[type="date"]:focus,
    textarea:focus {
        border-color: #4e54c8;
        box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.1);
    }

  
    .post-ad-btn {
        background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
        border: none;
        border-radius: 12px;
        font-size: 18px;
        font-weight: bold;
        padding: 14px;
        cursor: pointer;
        transition: 0.3s;
    }

    .post-ad-btn:hover {
        background: linear-gradient(135deg, #3a3fc5 0%, #757bfd 100%);
    }

 
    .price-estimate {
        background: #edf2fb;
        border: 1px solid #ccd5e4;
        padding: 15px;
        border-radius: 10px;
        font-size: 16px;
        margin-top: 20px;
        color: #333;
    }


    #preview {
        max-width: 100%;
        max-height: 300px;
        margin-top: 10px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

 
    .confirmation-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(33, 37, 41, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .confirmation-modal .modal-content {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 450px;
        text-align: center;
    }

    .modal-content h3 {
        margin-bottom: 15px;
        color: #2d2f48;
    }

    .modal-content p {
        margin-bottom: 20px;
        color: #6c757d;
    }

    .modal-actions {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .btn-secondary {
        background: #e2e6ea;
        color: #495057;
    }

    .btn-secondary:hover {
        background: #d0d4d8;
    }

    /* --- Responsive Tweaks --- */
    @media screen and (max-width: 768px) {
        .equal-sections-form {
            flex-direction: column;
        }

        .main-content {
            padding: 20px;
        }
    }
</style>


<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/advertisements.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/advertise.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/home.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>




<div class="wrapper flex-row" style="margin-bottom: 80px; margin-top: 80px;">
    <h2 class="title" style="font-family: 'Poppins';">Advertise With Us!</h2>
    <div class="main-content">

        <div class="ad-title flex-col" style="text-align: left;">

            <p class="text-grey" style="font-size: 20px;">
                The advertisement rate is LKR 1000 per week. And this payment is not refundable. Please make sure that you have correctly filled all the information.
                After being reviewed by us, your advertisement will be up on our website, and we will notify you soon.
            </p>
        </div>
        <hr>

        <div class="ad-form flex-col">
            <div class="create-ad-form" id="create-ad">
                <form id="advertisementForm" class="equal-sections-form">
                    
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
                                    <input type="date" id="startDate" name="startDate" required min="<?= date('Y-m-d'); ?>">
                                </div>
                                <div>
                                    <label class="lbl">End Date</label><br>
                                    <input type="date" id="endDate" name="endDate" required min="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="field radio-btns flex-row" style="gap: 30px; margin-top: 20px;">
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-paid" name="adStatus" value="1" required>
                                <label for="status-paid" class="lbl">Paid</label>
                            </div>
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-pending" name="adStatus" value="0" required>
                                <label for="status-pending" class="lbl">Payment pending</label>
                            </div>
                        </div> -->
                        <div id="priceEstimate" class="price-estimate" style="display: none;">
                            <p>Estimated cost: <span id="estimatedAmount">LKR 0</span> (<span id="estimatedWeeks">0</span> weeks)</p>
                        </div>
                        <div class="field img-link">
                            <label class="lbl">Advertisement Image</label><br><br>
                            <input type="file" name="adImage" accept="image/*" required onchange="previewImage(this)" class="custom-file-input">
                        </div>
                        <button class="btn btn-accent post-ad-btn" type="submit" id="submitBtn">
                            <span id="btnText">Submit Ad</span>
                            <!-- <div id="spinner" class="spinner-border spinner-border-sm d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div> -->
                        </button>
                        <!-- <p class="conditions" >This payment is non-refund?/able. Please ensure all details are correct before proceeding.</p> -->
                    </div>

                 
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

        <?php include_once APPROOT . '/views/components/alertBox.php'; ?>
    </div>
</div>
<footer class="footer" style="background-color: black;">
    <div class="footer-content">
        <div class="footer-logo-section">
            <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="QuickGig Logo" class="footer-logo" />
            <p class="footer-text">
                Great platform for job seekers who<br>
                are passionate about startups. Find<br>
                your dream job easier.
            </p>
        </div>

        <div class="footer-links">
            <a href="<?= ROOT ?>/home/aboutUs">About Us</a>
            <a href="<?= ROOT ?>/home/contact">Contact Us</a>
        </div>
    </div>

    <hr class="footer-divider">
    <p class="copyright">&copy; 2024 QuickGig. All rights reserved.</p>
</footer>

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

    // Fetch advertiser details by email
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        if (!email) return;

        fetch('<?php echo ROOT; ?>/manager/getAdvertiserByEmail', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${encodeURIComponent(email)}`
        }).then(res => res.json()).then(data => {
            if (data.error) {
                document.getElementById('advertiserName').value = '';
                document.getElementById('contact').value = '';
            } else {
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
        const estimatedAmount = document.getElementById('estimatedAmount').textContent;
        const estimatedWeeks = document.getElementById('estimatedWeeks').textContent;

        // Show confirmation popup
        const modal = document.createElement('div');
        modal.classList.add('confirmation-modal');
        modal.innerHTML = `
        <div class="modal-content">
            <h3>Confirm Submission</h3>
            <p>The estimated price is <strong>${estimatedAmount}</strong> for <strong>${estimatedWeeks}</strong> weeks.</p>
            <p>Please note that the payment is non-refundable. Do you wish to proceed?</p>
            <div class="modal-actions">
                <button id="confirmBtn" class="btn btn-accent">Confirm</button>
                <button id="cancelBtn" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    `;

        document.body.appendChild(modal);

        // Wait for user confirmation
        const userConfirmed = await new Promise((resolve) => {
            document.getElementById('confirmBtn').addEventListener('click', () => {
                modal.remove();
                resolve(true);
            });

            document.getElementById('cancelBtn').addEventListener('click', () => {
                modal.remove();
                resolve(false);
            });
        });

        if (!userConfirmed) {
            return; // Exit if user cancels
        }

        // Show loading state
        submitBtn.disabled = true;
        btnText.textContent = 'Processing...';

        try {
            const formData = new FormData(this);

            const response = await fetch('<?= ROOT ?>/advertise/postAdvertisement', {
                method: 'POST',
                body: formData
            });

            const responseText = await response.text();

            let result;
            try {
                result = JSON.parse(responseText);
            } catch (err) {
                console.error('Server response is not valid JSON:', responseText);
                throw new Error('Server returned invalid JSON or HTML.');
            }

            if (result.status === 'payment_required') {
                window.location.href = result.redirectUrl;
            } else if (result.success) {
                showAlert('Advertisement submitted successfully!', 'success');
                this.reset();
                document.getElementById('preview').src = '';
                document.getElementById('priceEstimate').style.display = 'none';
            } else {
                showAlert(result.error || 'An error occurred. Please try again.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again.', 'error');
        } finally {
            submitBtn.disabled = false;
            btnText.textContent = 'Submit Ad';
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

        calculatePrice();

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