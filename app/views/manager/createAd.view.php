<?php 
require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager-commons.css"> 

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content">
        <div class="ad-title flex-row">
            <i class="fa-solid fa-arrow-left" 
               onclick="window.location.href='<?=ROOT?>/manager/advertisements'" 
               style="cursor: pointer;">
            </i>
            <h3 class="title">Create Ad</h3>
        </div>

        <div class="ad-form flex-col">
            <div class="create-ad-form flex-row" id="create-ad">
            <form action="<?=ROOT?>/manager/postAdvertisement" method="POST" enctype="multipart/form-data" class="flex-row">
                    
                    <div class="advertiser_details">
                        <h4>Advertiser Details</h4>
                            <div class="field">
                                <label class="lbl">Advertiser Name</label><br>
                                <input type="text" id="advertiserName" name="advertiserName" required>
                            </div>

                            <div class="field">
                                <label class="lbl">Contact Number</label><br>
                                <input type="text" id="contact" name="contact" required>
                            </div>
                            
                            <div class="field">
                                <label class="lbl">Email</label><br>
                                <input type="email" id="email" name="email" required>

                            </div>

                    </div>
                    <div class="advertisement-details">
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
                            <div class="flex-row" style="gap: 10px;">
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
                                <input type="radio" id="status-paid" name="adStatus" value="1">
                                <label for="status-paid" class="lbl">Paid</label>
                            </div>
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-pending" name="adStatus" value="0">
                                <label for="status-pending" class="lbl">Payment pending</label>
                            </div>
                        </div>


                        <div class="links flex-col">
                            <div class="field img-link">
                                <label class="lbl">Advertisement Image</label><br><br>
                                <input type="file" name="adImage" accept="image/*" required onchange="previewImage(this)" class="custom-file-input">
                                
                            </div>
                        </div>
                        <button class="btn btn-accent" type="submit" name="createAdvertisement">Post Ad</button>
                    </div>
                    <div id="imagePreview" style="margin-top: 10px; max-width: 300px;">
                                    <img id="preview" src="" alt="Image Preview" 
                                        style="display: none; width: 100%; height: auto;">
                                </div>
                </form>
            </div>
        </div>

        <?php
            // Check if there are any error messages in the session
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                // Clear the error message after displaying it
                unset($_SESSION['error']);
            }
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
</script>


