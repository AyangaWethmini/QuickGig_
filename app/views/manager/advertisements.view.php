<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>


<div class="wrapper flex-row" style="margin-top: 100px;">

    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <div class="header flex-row">
            <h3>Current Advertisements</h3>
            <button class="btn btn-accent" onclick="showForm()"> + Post Advertisement</button>
        </div>
        <hr>
        
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search advertisements"
                aria-label="Search">
        </div>

        <div class="filter flex-row">
            <span>
                <h3>All Ads</h3>
                <p class="text-grey">Showing <?= count($advertisements) ?> results</p>
            </span>

            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Most recent</option>
                    <option value="views">Highest views</option>
                </select>
                <button id="gridButton" onclick="toggleView()">☰</button>
                </div>
        </div>
        <br><br>

        <div class="ads container">
        <?php foreach ($advertisements as $ad): ?> 
            <div class="ad-card flex-row container">
                <div class="image" >
                    <?php if ($ad->img): ?>
                        <?php 
                            // Get the mime type from the first few bytes of the BLOB
                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                            $mimeType = $finfo->buffer($ad->img);
                        ?>
                        <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" alt="Advertisement image">
                    <?php else: ?>
                        <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available">
                    <?php endif; ?>
                </div>
                <div class="details flex-col">
                    <p class="ad-title"><?= htmlspecialchars($ad->adTitle) ?></p>
                    <p class="advertiser">Advertiser ID: <?= htmlspecialchars($ad->advertiserID) ?></p>
                    <p class="description"><?= htmlspecialchars($ad->adDescription) ?></p>
                    <p class="contact">Link: <a href="<?= htmlspecialchars($ad->link) ?>"><?= htmlspecialchars($ad->link) ?></a></p>
                    <div class="status flex-row">
                        <span class="badge <?= $ad->adStatus == 1 ? 'active' : 'inactive' ?>">
                            <?= $ad->adStatus == 1 ? 'Active' : 'Inactive' ?>
                        </span>
                    </div>
                </div>
                <div class="ad-actionbtns flex-col">
                    <button class="btn btn-accent" onclick="showUpdateForm(<?php echo $ad->advertisementID ?>)">Edit</button>
                    <button class="btn btn-del" onclick="deleteAd(<?php echo $ad->advertisementID ?>)">Delete</button>
                </div>
            </div>
        <?php endforeach ?>

        </div>

        <div class="create-ad-form container hidden" id="create-ad">
            <div class="title flex-row">
                <i class="fa-solid fa-arrow-left" onclick="hideForm('create-ad')" style="cursor: pointer;"></i>
                <p class="title">Create Ad</p>
            </div>

            <form action="<?=ROOT?>/manager/postAdvertisement" method="POST" enctype="multipart/form-data">
                <div class="form-field">
                    <label class="lbl">Title</label><br>
                    <input type="text" name="adTitle" required>
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



        <!-- update ad form -->
        <div class="update-ad-form container hidden" id="update-ad">
            <div class="title flex-row">
                <i class="fa-solid fa-arrow-left" onclick="hideForm('update-ad')" style="cursor: pointer;"></i>
                <p class="title">Update Ad</p>
            </div>

            <form action="<?=ROOT?>/manager/updateAdvertisement/<?= $ad->advertisementID ?>" method="POST" enctype="multipart/form-data">
                <div class="form-field">
                    <label class="lbl">Title</label><br>
                    <input type="text" name="adTitle" required value="<?= htmlspecialchars($ad->adTitle) ?>">
                </div>
                
                <div class="form-field">
                    <label class="lbl">Description</label><br>
                    <textarea name="adDescription" rows="6" required><?= htmlspecialchars($ad->adDescription) ?></textarea>
                </div>
                
                <div class="form-field">
                    <label class="lbl">Link</label><br>
                    <input type="url" name="link" required  placeholder="<?= htmlspecialchars($ad->link) ?>">
                </div>
                
                <div class="form-field radio-btns flex-row" style="gap: 10px">
                    <input type="radio" id="status-paid" name="adStatus" value="1" required <?= $ad->adStatus == 1 ? 'checked' : '' ?>>
                    <label for="status-paid">Paid</label>
                    <input type="radio" id="status-pending" name="adStatus" value="0" <?= $ad->adStatus == 0 ? 'checked' : '' ?>>
                    <label for="status-pending">Pending</label>
                </div>
                <br>
                
                <div class="links flex-col">
                    <div class="form-field img-link">
                        <label class="lbl">Advertisement Image</label><br>
                        <input type="file" name="adImage" accept="image/*">
                        <div id="imagePreview" class="image-preview"></div>
                    </div>
                    
                    <button class="btn btn-accent"  type="submit" name="updateAdvertisement">Update Ad</button>
                </div>
            </form>
        </div>

        </div>


        


        
    </div>


    <div id="delete-confirmation" class="modal" style="display: none;">
        <div class="modal-content">
            <p>Are you sure you want to delete this advertisement?</p>
            <button id="confirm-yes" class="popup-btn-delete-ad">Yes</button>
            <button id="confirm-no" class="popup-btn-delete-ad">No</button>
        </div>
</div>



<script>
const form = document.getElementById("create-ad");
const updateForm = document.getElementById("update-ad");

function showUpdateForm(ad) {
    updateForm.classList.remove("hidden");
    updateForm.classList.add("show");
}

function showForm() {
    if (form.classList.contains("hidden")) {
        form.classList.remove("hidden");
        setTimeout(() => {
            form.classList.add("show");
        }, 50);
    }
}

function hideForm(formId) {
    const selectedForm = document.getElementById(formId);
    selectedForm.classList.remove("show");
    setTimeout(() => {
        selectedForm.classList.add("hidden");
    }, 500);
}



function deleteAd(adId) {
    if (confirm('Are you sure you want to delete this advertisement?')) {
        // Using POST instead of DELETE
        fetch(`<?=ROOT?>/manager/deleteAdvertisement/${adId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                alert('Advertisement deleted successfully');
                window.location.reload();
            } else {
                alert('Failed to delete advertisement');
            }
        })
    }
}


function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Image preview" style="max-width: 200px; margin-top: 10px;">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '';
    }
}

</script>
