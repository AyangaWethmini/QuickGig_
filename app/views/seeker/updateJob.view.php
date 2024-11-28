<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/post_job.css">

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
                        <input type="radio" name="shift" value="Daytime" <?= $availability->shift === 'Day' ? 'checked' : '' ?>> 
                    </p><br>
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Night time
                        <input type="radio" name="shift" value="Night time" <?= $availability->shift === 'Night' ? 'checked' : '' ?>> 
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

            <!-- Location Field -->
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Add Location</p>
                    <p class="text-grey desc">Add the location where the employee should attend.</p>
                </div>
                <div class="user-input">
                    <input type="text" name="location" value="<?= htmlspecialchars($availability->location) ?>" placeholder="Add location using Google Maps" required>
                </div>
            </div>
            <hr>

            <!-- Action Buttons -->
            <div class="post-job-buttons flex-row">
                <button class="btn btn-accent" type="reset">Discard</button>
                <button class="btn btn-accent" type="submit">Update Availability</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Set today's date as the minimum allowed date
    const today = new Date().toISOString().split("T")[0];
    document.getElementById('availableDate').setAttribute('min', today);
</script>
