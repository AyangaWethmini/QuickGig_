<?php 
require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager-commons.css"> 

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 80px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content">
        <div class="ad-title flex-row">
            <i class="fa-solid fa-arrow-left" 
               onclick="window.location.href='<?=ROOT?>/manager/advertisements'" 
               style="cursor: pointer;">
            </i>
            <h2 class="title">Create Ad</h2>
        </div>
        <hr>

        <div class="ad-form flex-col">
            <div class="create-ad-form" id="create-ad">
                <form action="<?=ROOT?>/manager/postAdvertisement" method="POST" enctype="multipart/form-data" class="equal-sections-form">
                   
                    <div class="advertiser_details section">
                        <h4>Advertiser Details</h4>
                        <div class="field">
                            <label class="lbl">Email</label><br>
                            <input type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Enter a valid email" required>
                        </div>
                        <div class="field">
                            <label class="lbl">Advertiser Name</label><br>
                            <input type="text" id="advertiserName" name="advertiserName" required>
                        </div>

                        <div class="field">
                            <label class="lbl">Contact Number</label><br>
                            <input type="text" id="contact" name="contact" pattern="07\d{8}" title="Enter a valid phone number starting with 07 and 10 digits total" required>
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
                            <input type="url" id="link" name="link"  pattern="https?://.+" title="Enter a valid URL starting with http:// or https://" required>
                        </div>

                        <div class="field">
                            <div class="flex-row" style="gap:93px;">
                                <div>
                                    <label class="lbl">Start Date</label><br>
                                    <input type="date" id="startDate" name="startDate" min="<?= date('Y-m-d');?>" required>
                                </div>
                                <div>
                                    <label class="lbl">End Date</label><br>
                                    <input type="date" id="endDate" name="endDate" min="<?= date('Y-m-d');?>" required>
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

                        <div class="field img-link">
                            <label class="lbl">Advertisement Image</label><br><br>
                            <input type="file" name="adImage" accept="image/*" required onchange="previewImage(this)" class="custom-file-input">
                        </div>

                        <button class="btn btn-accent post-ad-btn" type="submit" name="createAdvertisement">Post Ad</button>
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
    </div>
</div>

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
        method : 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body : `email=${encodeURIComponent(email)}`
    }).then(res => res.json()).then(data => {
    
        if(!data.error){
            document.getElementById('advertiserName').value = data.advertiser.advertiserName ?? '';
            document.getElementById('contact').value = data.advertiser.contact ?? '';
        }
    }).catch(err => {
        console.error('Error:', err);    
    });
});



document.querySelector('form').addEventListener('submit', function(event) {
    let isValid = true;
    const email = document.getElementById('email').value.trim();
    const advertiserName = document.getElementById('advertiserName').value.trim();
    const contact = document.getElementById('contact').value.trim();
    const adTitle = document.getElementById('adTitle').value.trim();
    const adDescription = document.getElementById('adDescription').value.trim();
    const link = document.getElementById('link').value.trim();
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const adImage = document.querySelector('input[name="adImage"]').files[0];

   
    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
        alert('Please enter a valid email address.');
        isValid = false;
    }

    
    if (advertiserName === '') {
        alert('Advertiser Name is required.');
        isValid = false;
    }

   
    if (!/^07\d{8}$/.test(contact)) {
        alert('Please enter a valid contact number starting with 07 and 10 digits total.');
        isValid = false;
    }

   
    if (adTitle === '') {
        alert('Advertisement Title is required.');
        isValid = false;
    }

    
    if (adDescription === '') {
        alert('Advertisement Description is required.');
        isValid = false;
    }

  
    if (!/^https?:\/\/.+/.test(link)) {
        alert('Please enter a valid URL starting with http:// or https://.');
        isValid = false;
    }

  
    if (startDate === '' || endDate === '') {
        alert('Start Date and End Date are required.');
        isValid = false;
    } else if (new Date(startDate) > new Date(endDate)) {
        alert('Start Date cannot be later than End Date.');
        isValid = false;
    }

   
    if (!adImage) {
        alert('Advertisement Image is required.');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }
});

</script>
