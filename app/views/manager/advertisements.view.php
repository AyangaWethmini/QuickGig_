<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/advertisements.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    <div class="main-content container">
        <div class="header flex-row">
            <h3>Current Advertisements</h3>
            <button class="btn btn-accent" id="post-ad-btn">+ Post Advertisement</button>
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
                    <div class="image">
                        <?php if ($ad->img): ?>
                            <?php
                            // Get the mime type from the first few bytes of the BLOB
                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                            $mimeType = $finfo->buffer($ad->img);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" alt="Advertisement image">
                        <?php else: ?>
                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available">
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
                        <button class="btn btn-accent" data-ad-id="<?= $ad->advertisementID ?>" onclick="showUpdateForm(<?php echo $ad->advertisementID ?>)">Edit</button>
                        <button class="btn btn-del" onclick="deleteAd(<?php echo $ad->advertisementID ?>)">Delete</button>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Create Ad Form -->
        <div class="create-ad-form container hidden" id="create-ad">
            <div class="title flex-row">
                <i class="fa-solid fa-arrow-left" onclick="hideForm('create-ad')" style="cursor: pointer;"></i>
                <p class="title">Create Ad</p>
            </div>

            <form action="<?= ROOT ?>/manager/postAdvertisement" method="POST" enctype="multipart/form-data">
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

<div id="delete-confirmation" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this advertisement?</p>
        <button id="confirm-yes" class="popup-btn-delete-ad">Yes</button>
        <button id="confirm-no" class="popup-btn-delete-ad">No</button>
    </div>
</div>

<script>
    // Ensure all the functions are defined before usage

    function showForm() {
        console.log("showForm function triggered");  // For debugging
        const form = document.getElementById("create-ad");
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
            fetch(`<?= ROOT ?>/manager/deleteAdvertisement/${adId}`, {
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
                });
        }
    }

    function showUpdateForm(adId) {
        // Assuming you have a form or page for updating ads
        const updateForm = document.getElementById("update-ad");
        updateForm.classList.remove("hidden");
        updateForm.classList.add("show");
    }

    // Make sure the event listeners are attached after DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        // Attach event listener to the button for showing the create ad form
        document.getElementById("post-ad-btn").addEventListener("click", showForm);

        // If you have any other logic to trigger the update form, do the same for the update button
        const updateButtons = document.querySelectorAll(".btn-accent");
        updateButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Assuming each button is associated with an ad id
                const adId = this.getAttribute("data-ad-id");  // Assuming you set the ad ID on the button
                showUpdateForm(adId);
            });
        });
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
