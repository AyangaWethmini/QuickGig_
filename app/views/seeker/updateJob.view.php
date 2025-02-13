<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/post_job.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/popUp.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>

    <div class="main-content container post-job-form">
        <p class="heading">
            Update Availability
        </p>
        <form class="form-section container" action="<?= ROOT ?>/seeker/updateAvailability/<?= htmlspecialchars($availability->availableID) ?>" method="POST">
            <hr>

            <!-- Description Field -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Description</p>
                </div>
                <div class="user-input" style="align-items: center; margin-top: 10px;">
                    <textarea name="description" rows="5" cols="30" required><?= htmlspecialchars($availability->description) ?></textarea>
                </div>
            </div>
            <hr>

            <!-- Type of Employment Field (Shift) -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Type of Employment</p>
                    <p class="text-grey desc">Select One</p>
                </div>
                <div class="user-input" style=" margin-top:10px;">
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Daytime 
                        <input type="radio" name="shift" value="Day" <?= $availability->shift === 'Day' ? 'checked' : '' ?>> 
                    </p><br>
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Night time
                        <input type="radio" name="shift" value="Night" <?= $availability->shift === 'Night' ? 'checked' : '' ?>> 
                    </p><br>
                </div>
            </div>
            <hr>

            <!-- Salary Field -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Salary (Per hour)</p>
                    <p class="text-grey desc">Please set the estimated salary range for the role.</p>
                </div>
                <div class="user-input">
                    <div class="salary-ph flex-row">
                        <input type="number" name="salary" id="salary-per-hr" value="<?= htmlspecialchars($availability->salary) ?>" min="0" required>
                        <select id="currency-select" class="currency-select" name="currency">
                            <option value="USD" <?= $availability->currency === 'USD' ? 'selected' : '' ?>>USD</option>
                            <option value="EUR" <?= $availability->currency === 'EUR' ? 'selected' : '' ?>>EUR</option>
                            <option value="GBP" <?= $availability->currency === 'GBP' ? 'selected' : '' ?>>GBP</option>
                            <option value="LKR" <?= $availability->currency === 'LKR' ? 'selected' : '' ?>>LKR</option>
                            <option value="AUD" <?= $availability->currency === 'AUD' ? 'selected' : '' ?>>AUD</option>
                            <option value="CAD" <?= $availability->currency === 'CAD' ? 'selected' : '' ?>>CAD</option>
                            <option value="CNY" <?= $availability->currency === 'CNY' ? 'selected' : '' ?>>CNY</option>
                            <option value="INR" <?= $availability->currency === 'INR' ? 'selected' : '' ?>>INR</option>
                            <option value="JPY" <?= $availability->currency === 'JPY' ? 'selected' : '' ?>>JPY</option>
                            <option value="NZD" <?= $availability->currency === 'NZD' ? 'selected' : '' ?>>NZD</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Duration (Time From/To) -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Duration</p>
                    <p class="text-grey desc">Specify the start and end time for the job.</p>
                </div>
                <div class="user-input duration flex-row">
                    <div class="start-time flex-col">
                        <label for="timeFrom">Start Time</label>
                        <input type="time" id="timeFrom" name="timeFrom" value="<?= htmlspecialchars($availability->timeFrom) ?>" required>
                    </div>
                    <div class="end-time flex-col">
                        <label for="timeTo">End Time</label>
                        <input type="time" id="timeTo" name="timeTo" value="<?= htmlspecialchars($availability->timeTo) ?>" required>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Date Field -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Date</p>
                    <p class="text-grey desc">Specify the date for the job.</p>
                </div>
                <div class="user-input flex-col">
                    <label for="availableDate">Date</label>
                    <input type="date" id="availableDate" name="availableDate" value="<?= htmlspecialchars($availability->availableDate) ?>" required>
                </div>
            </div>
            <hr>

            <!-- Categories Field -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Tags</p>
                    <p class="text-grey desc">You can add skills, jobs and more</p>
                </div>
                <div class="user-input">
                    <div class="user-input flex-col">
                        <div class="flex-row" style="gap: 20px;">
                            <div class="btn btn-trans" onclick="showAddTagPopup('job')" name="categories">+ Add Categories</div>
                        </div>
                        <div id="tags-container" class="tags-container">
                            <?php 
                            $categories = is_string($availability->categories) ? json_decode($availability->categories, true) : $availability->categories;
                            if (is_array($categories)) {
                                foreach ($categories as $category) {
                                    echo '<div class="tag">' . htmlspecialchars($category) . '<span class="remove-btn" onclick="this.parentElement.remove()">×</span><input type="hidden" name="categories[]" value="' . htmlspecialchars($category) . '"></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Location Field -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Add Location</p>
                    <p class="text-grey desc">Please mention your location so that your client knows.</p>
                </div>
                <div class="user-input">
                    <button class="btn btn-trans">Add your Location</button>
                    <p>Or</p>
                    <input type="text" name="location" value="<?= htmlspecialchars($availability->location) ?>" placeholder="Type your location" required>
                </div>
            </div>
            <hr>

            <!-- Action Buttons -->
            <div class="post-job-buttons flex-row">
                <button class="btn btn-accent">Discard</button>
                <button class="btn btn-accent" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>

<div id="tag-limit-popup" class="modal" style="display: none;">
    <div class="modal-content">
        <p>You can only add up to five categories.</p>
        <button id="popup-ok" class="popup-btn-ok" type="button">Ok</button>
    </div>
</div>

<div id="add-tag-popup" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Enter tags:</p>
        <input type="text" id="tag-input" class="popup-input">
        <button id="add-tag-btn" class="popup-btn-add" type="button">Add</button>
        <button id="cancel-tag-btn" class="popup-btn-cancel" type="button">Cancel</button>
    </div>
</div>

<script>
    function showAddTagPopup(type) {
        const tagContainer = document.getElementById('tags-container');
        if (tagContainer.children.length >= 5) {
            showTagLimitPopup();
            return;
        }

        var modal = document.getElementById('add-tag-popup');
        modal.style.display = 'flex';

        document.getElementById('add-tag-btn').onclick = function() {
            const tagText = document.getElementById('tag-input').value;
            if (tagText) {
                addTag(tagText);
                modal.style.display = 'none';
                document.getElementById('tag-input').value = '';
            }
        };

        document.getElementById('cancel-tag-btn').onclick = function() {
            modal.style.display = 'none';
            document.getElementById('tag-input').value = '';
        };
    }

    function addTag(tagText) {
        const tagContainer = document.getElementById('tags-container');

        // Create tag element
        const tag = document.createElement('div');
        tag.className = 'tag';
        tag.textContent = tagText;

        // Add remove button
        const removeBtn = document.createElement('span');
        removeBtn.className = 'remove-btn';
        removeBtn.textContent = '×';
        removeBtn.onclick = () => tag.remove();

        // Append remove button to tag
        tag.appendChild(removeBtn);

        // Append tag to container
        tagContainer.appendChild(tag);

        // Create hidden input to store tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'categories[]';
        hiddenInput.value = tagText;
        tag.appendChild(hiddenInput);
    }

    function showTagLimitPopup() {
        var modal = document.getElementById('tag-limit-popup');
        modal.style.display = 'flex';

        document.getElementById('popup-ok').onclick = function() {
            modal.style.display = 'none';
        };
    }

    // Set today's date as the minimum allowed date
    const today = new Date().toISOString().split("T")[0];
    document.getElementById('availableDate').setAttribute('min', today);
</script>