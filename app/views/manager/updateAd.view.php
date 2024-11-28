<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content">
    <div class="update-ad-form container" id="update-ad">
        <div class="title flex-row">
            <i class="fa-solid fa-arrow-left" onclick="hideForm('update-ad')" style="cursor: pointer;"></i>
            <p class="title">Update Ad</p>
            </div>

            <form action="<?=ROOT?>/manager/updateAdvertisement/<?= $data['ad']->advertisementID ?>" method="POST" enctype="multipart/form-data">
                <div class="form-field">
                    <label class="lbl">Title</label><br>
                    <input type="text" name="adTitle" required value="<?= $data['ad']->adTitle ?>" style="width: 400px; padding: 0px;">
                </div>
                
                <div class="form-field">
                    <label class="lbl">Description</label><br>
                    <textarea name="adDescription" rows="6" required><?= $data['ad']->adDescription ?></textarea>
                </div>
                
                <div class="form-field">    
                    <label class="lbl">Link</label><br>
                    <input type="url" name="link"   placeholder="<?= $data['ad']->link ?>">
                </div>
                
                <div class="form-field radio-btns flex-row" style="gap: 10px">
                    <input type="radio" id="status-paid" name="adStatus" value="1" required <?= $data['ad']  ->adStatus == 1 ? 'checked' : '' ?>>
                    <label for="status-paid">Paid</label>
                    <input type="radio" id="status-pending" name="adStatus" value="0" <?= $data['ad']->adStatus == 0 ? 'checked' : '' ?>>
                    <label for="status-pending">Pending</label>
                </div>
                <br>
                
                <div class="links flex-col">
                    <div class="form-field img-link">
                        <label class="lbl">Advertisement Image</label><br>
                        <input type="file" name="adImage" accept="image/*">
                    </div>
                    
                    <button class="btn btn-accent"  type="submit" name="updateAdvertisement">Update Ad</button>
                </div>
            </form>
    </div>

    </div>
</div>

