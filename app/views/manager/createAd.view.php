<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content">

    <div class="create-ad-form container" id="create-ad">
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
                
                <div class="form-field radio-btns flex-row" style="gap: 10px">
                    <input type="radio" id="status-paid" name="adStatus" value="1" required>
                    <label for="status-paid">Paid</label>
                    <input type="radio" id="status-pending" name="adStatus" value="0">
                    <label for="status-pending">Pending</label>
                </div>
                <br>
                
                <div class="links flex-col">
                    <div class="form-field img-link">
                        <label class="lbl">Advertisement Image</label><br>
                        <input type="file" name="adImage" accept="image/*" required>
                    </div>
                    
                    <button class="btn btn-accent" type="submit" name="createAdvertisement">Post Ad</button>
                </div>
            </form>
        </div>
        
    </div>
</div>


