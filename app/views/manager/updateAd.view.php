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
            <h2 class="title">Update Ad</h2>
        </div>
        <hr>

        <div class="ad-form flex-col">
            <div class="update-ad-form" id="update-ad">
                <form action="<?=ROOT?>/manager/updateAdvertisement/<?= $data['ad']->advertisementID ?>" method="POST" enctype="multipart/form-data" class="equal-sections-form">
                    <!-- Advertiser Details
                    <div class="advertiser_details section">
                        <h4>Advertiser Details</h4>
                        <div class="field">
                            <label class="lbl">Advertiser Name</label><br>
                            <input type="text" id="advertiserName" name="advertiserName" value="<?= htmlspecialchars($data['ad']->advertiserName) ?>" required>
                        </div>

                        <div class="field">
                            <label class="lbl">Contact Number</label><br>
                            <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($data['ad']->contact) ?>" required>
                        </div>

                        <div class="field">
                            <label class="lbl">Email</label><br>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['ad']->email) ?>" required>
                        </div>
                    </div> -->

                    <!-- Advertisement Details -->
                    <div class="advertisement-details section">
                        <h4>Advertisement Details</h4>

                        <div class="field">
                            <label class="lbl">Title</label><br>
                            <input type="text" id="adTitle" name="adTitle" value="<?= htmlspecialchars($data['ad']->adTitle) ?>" required>
                        </div>

                        <div class="field">
                            <label class="lbl">Description</label><br>
                            <textarea id="adDescription" name="adDescription" required><?= htmlspecialchars($data['ad']->adDescription) ?></textarea>
                        </div>

                        <div class="field">
                            <label class="lbl">Link</label><br>
                            <input type="url" id="link" name="link" value="<?= htmlspecialchars($data['ad']->link) ?>" required>
                        </div>

                        <div class="field">
                            <div class="flex-row" style="gap:93px;">
                                <div>
                                    <label class="lbl">Start Date</label><br>
                                    <input type="date" id="startDate" name="startDate" value="<?= date('Y-m-d', strtotime($data['ad']->startDate)) ?>" required>
                                </div>
                                <div>
                                    <label class="lbl">End Date</label><br>
                                    <input type="date" id="endDate" name="endDate" value="<?= date('Y-m-d', strtotime($data['ad']->endDate)) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="field radio-btns flex-row" style="gap: 30px; margin-top: 20px;">
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-active" name="adStatus" value="1" <?= isset($data['ad']->adStatus) && $data['ad']->adStatus == 1 ? 'checked' : '' ?> required>
                                <label for="status-active" class="lbl">Active</label>
                            </div>
                            <div class="flex-row" style="gap : 5px;">
                                <input type="radio" id="status-inactive" name="adStatus" value="0" <?= isset($data['ad']->adStatus) && $data['ad']->adStatus == 0 ? 'checked' : '' ?> required>
                                <label for="status-inactive" class="lbl">Inactive</label>
                            </div>
                        </div>

                        <div class="field img-link">
                            <label class="lbl">Advertisement Image</label><br><br>
                            <input type="file" name="adImage" accept="image/*" onchange="previewImage(this)" class="custom-file-input">
                            <p class="text-grey" style="margin-top: 5px;">(Current image will be kept if no new image is selected)</p>
                        </div>

                        <button class="btn btn-accent post-ad-btn" type="submit" name="updateAdvertisement">Update Ad</button>
                    </div>

                    <!-- Image Preview -->
                    <div class="image-preview section">
                        <h4>Image Preview</h4>
                        <div id="imagePreview">
                            <?php if (!empty($data['ad']->img)): ?>
                                <img id="preview" src="data:image/jpeg;base64,<?= base64_encode($data['ad']->img) ?>" alt="Current Advertisement Image">
                            <?php else: ?>
                                <img id="preview" src="" alt="Image Preview" style="display: none;">
                            <?php endif; ?>
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
    }
}



</script>