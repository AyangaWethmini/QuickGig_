<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <h1>All Users</h1>
        <div class="admin-announcement-filterheader">
            <div class="search-container">
                <input type="text" id="userSearchInput" placeholder="Search by email..." class="search-input">
                <button onclick="clearSearch()" class="clear-search-btn">Clear</button>
            </div>
        </div>
        <div class="complaints-container container">
            <?php if (empty($data['users'])): ?>
                <div class="no-results">
                    No users found.
                </div>
            <?php else: ?>
                <?php foreach ($data['users'] as $user): ?>
                    <?php if ($user->roleID != 0 && $user->roleID != 1): ?>
                        <div class="complaint container user-item" data-email="<?php echo strtolower($user->email); ?>" style="border: 2px solid <?php echo $user->activationCode ? 'green' : 'red'; ?>;">
                            <div class="complaint-details flex-col">
                                <div class="complaint-details flex-row">
                                    <div class="the-complaint">
                                        <strong>Account ID:</strong> <?php echo $user->accountID; ?><br>
                                        <strong>Email:</strong> <?php echo $user->email; ?><br>
                                        <strong>Role:</strong>
                                        <?php
                                        if ($user->roleID == 2) {
                                            echo 'Individual';
                                        } elseif ($user->roleID == 3) {
                                            echo 'Organization';
                                        } else {
                                            echo 'Unknown';
                                        }
                                        ?><br>
                                    </div>
                                    <div>
                                        <button class="btn btn-delete" onclick="confirmDelete('<?php echo $user->accountID; ?>')">Delete</button>

                                        <a href="<?php echo ROOT; ?>/admin/deactivateUser/<?php echo $user->accountID; ?>">
                                            <button style="background-color:brown;" class="btn btn-update">Deactivate</button>
                                        </a>

                                        <a href="<?php echo ROOT; ?>/admin/activateUser/<?php echo $user->accountID; ?>">
                                            <button style="background-color:green;" class="btn btn-update">Activate</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="pagination-container">
            <div class="pagination">
                <!-- Always show Previous button -->
                <a href="<?= ROOT ?>/admin/adminmanageusers?page=<?= max(1, $data['currentPage'] - 1) ?>"
                    class="page-link <?= $data['currentPage'] <= 1 ? 'disabled' : '' ?>">
                    &laquo;
                </a>

                <!-- Always show page numbers -->
                <?php for ($i = 1; $i <= max(1, $data['totalPages']); $i++): ?>
                    <a href="<?= ROOT ?>/admin/adminmanageusers?page=<?= $i ?>"
                        class="page-link <?= $i == $data['currentPage'] ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <!-- Always show Next button -->
                <a href="<?= ROOT ?>/admin/adminmanageusers?page=<?= min($data['totalPages'], $data['currentPage'] + 1) ?>"
                    class="page-link <?= $data['currentPage'] >= $data['totalPages'] ? 'disabled' : '' ?>">
                    &raquo;
                </a>
            </div>
            <div class="pagination-info">
                <!-- Showing page <?= $data['currentPage'] ?> of <?= max(1, $data['totalPages']) ?> -->
                (Total users: <?= $data['totalUsers'] ?>)
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-confirmation" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this user? This action is irreversible.</p>
        <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
        <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;"></form>

<style>
    .no-results {
        text-align: center;
        padding: 30px;
        color: #666;
        font-size: 16px;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin: 20px 0;
    }

    .admin-container {
        position: relative;
        min-height: 600px;
        padding-bottom: 100px;
        display: flex;
        flex-direction: column;
    }

    .complaints-container {
        flex: 1;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 60px;
    }

    .complaint.container {
        margin: 0;
        width: 90%;
    }

    .pagination-container {
        position: absolute;
        bottom: 110px;
        left: 0;
        right: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
        padding: 15px 0;
        /* margin: 0; */
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        min-width: 300px;
    }

    .page-link {
        padding: 8px 16px;
        min-width: 40px;
        text-align: center;
        border: 1px solid rgb(198, 198, 249);
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .page-link.disabled {
        opacity: 0.5;
        pointer-events: none;
        background-color: #f0f0f0;
    }

    .page-link:hover:not(.disabled) {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    .page-link.active {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    .pagination-info {
        color: #666;
        font-size: 0.9em;
    }

    .admin-announcement-filterheader {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;

    }

    .search-container {

        display: flex;
        justify-content: center;
        margin: 20px 0 30px;
        width: 100%;
        max-width: 600px;
    }

    .search-input {
        width: 100%;
        padding: 12px 20px;
        border: 2px solid #ddd;
        border-radius: 25px;
        font-size: 16px;
        outline: none;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: rgb(198, 198, 249);
        box-shadow: 0 0 8px rgb(198, 198, 249);
    }

    .clear-search-btn {
        margin-left: 10px;
        padding: 0 20px;
        background-color: rgb(198, 198, 249);
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .clear-search-btn:hover {
        background-color: #7f8c8d;
    }

    .no-results {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    /* Container for user items */
    .complaints-container {
        min-height: 400px;
    }

    /* Add this for the user items container */
    .user-item {
        margin-bottom: 20px !important;
    }
</style>

<script>
    // User search functionality
    const searchInput = document.getElementById('userSearchInput');
    const userItems = document.querySelectorAll('.user-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let resultsFound = false;

        userItems.forEach(item => {
            const email = item.getAttribute('data-email');

            if (email.includes(searchTerm)) {
                item.style.display = 'block';
                resultsFound = true;
            } else {
                item.style.display = 'none';
            }
        });

        // Hide pagination when searching
        const paginationContainer = document.querySelector('.pagination-container');
        paginationContainer.style.display = searchTerm ? 'none' : 'flex';

        // Show no results message if needed
        let noResultsMsg = document.querySelector('.no-results');
        if (!resultsFound && searchTerm !== '') {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.className = 'no-results';
                noResultsMsg.textContent = 'No users found matching your search.';
                document.querySelector('.complaints-container').appendChild(noResultsMsg);
            }
        } else if (noResultsMsg) {
            noResultsMsg.remove();
        }
    });

    function clearSearch() {
        searchInput.value = '';
        userItems.forEach(item => {
            item.style.display = 'block';
        });

        // Show pagination again
        const paginationContainer = document.querySelector('.pagination-container');
        paginationContainer.style.display = 'flex';

        const noResultsMsg = document.querySelector('.no-results');
        if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    function confirmDelete(accountID) {
        var modal = document.getElementById('delete-confirmation');
        modal.style.display = 'flex';

        document.getElementById('confirm-yes').onclick = function() {
            var form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/admin/deleteUser';
            form.innerHTML = '<input type="hidden" name="accountID" value="' + accountID + '">';
            modal.style.display = 'none';

            form.submit();
        };

        document.getElementById('confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }

    // Close the modal when clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('delete-confirmation');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>