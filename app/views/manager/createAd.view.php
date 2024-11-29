<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>

<style>
    .form-field{
        margin-top: 10px;
    }
</style>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content">

    <div class="create-ad-form container flex-col" id="create-ad">
            <div class="title flex-row">
                <i class="fa-solid fa-arrow-left" onclick="window.location.href='<?=ROOT?>/manager/advertisements'" style="cursor: pointer;"></i>
                <p class="title">Create Ad</p>
            </div>

            <form action="<?=ROOT?>/manager/postAdvertisement" method="POST" enctype="multipart/form-data">
                <div class="form-field">
                    <label class="lbl">Title</label><br>
                    <input type="text" name="adTitle" required style="width: 400px; padding: 0px;">
                </div>
                
                <div class="form-field">
                    <label class="lbl">Description</label><br>
                    <textarea name="adDescription" rows="6" required></textarea>
                </div>
                
                <div class="form-field">
                    <label class="lbl">Link</label><br>
                    <input type="url" name="link" required>
                </div>

                <div class="form-field">
                    <label class="lbl">Duration (hours)</label><br>
                    <input type="number" name="duration" min="1" required style="width: 400px; padding: 0px; height: 35px;">
                </div>
                
                <div class="form-field radio-btns flex-row" style="gap: 30px; margin-top : 20px">
                   <div>
                        <input type="radio" id="status-paid" name="adStatus" value="1" required>
                        <label for="status-paid">Paid</label>
                   </div>
                <div>
                    <input type="radio" id="status-pending" name="adStatus" value="0">
                    <label for="status-pending">Pending</label>
                </div>
                </div>
                <br>
                
                <div class="links flex-col">
                    <div class="form-field img-link">
                        <label class="lbl">Advertisement Image</label><br>
                        <input type="file" name="adImage" accept="image/*" required onchange="previewImage(this)">
                        <div id="imagePreview" style="margin-top: 10px; max-width: 300px;">
                            <img id="preview" src="" alt="Image Preview" style="display: none; width: 100%; height: auto;">
                        </div>
                    </div>
                    
                    <button class="btn btn-accent" type="submit" name="createAdvertisement">Post Ad</button>
                </div>
            </form>
        </div>
        
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


