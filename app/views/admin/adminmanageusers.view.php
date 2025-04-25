<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_manageusers.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <h1>All Users</h1>
        <div class="admin-announcement-filterheader">
            <div class="search-container">
                <input type="text" id="userSearchInput" placeholder="Search by email..." class="search-input">
                <button onclick="searchUsers()" class="search-btn">Search</button>
                <button onclick="clearSearch()" class="clear-search-btn">Clear</button>
            </div>
        </div>
        <div id="search-results" class="complaints-container container" style="display: none;">
            <!-- Search results will be displayed here -->
        </div>
        <div id="normal-results" class="complaints-container container">
            <?php if (empty($data['users'])): ?>
                <div class="no-results">
                    No users found.
                </div>
            <?php else: ?>
                <?php foreach ($data['users'] as $user): ?>
                    <?php if ($user->roleID != 0 && $user->roleID != 1): ?>
                        <div class="complaint container user-item" data-email="<?php echo strtolower($user->email); ?>" data-id="<?php echo $user->accountID; ?>" style="border: 2px solid <?php echo $user->activationCode ? 'green' : 'red'; ?>;">
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
        <div id="pagination-container" class="pagination-container">
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

<script>
    // User search functionality
    const searchInput = document.getElementById('userSearchInput');
    const normalResults = document.getElementById('normal-results');
    const searchResults = document.getElementById('search-results');
    const paginationContainer = document.getElementById('pagination-container');

    // Add event listener for Enter key on search input
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchUsers();
        }
    });

    function searchUsers() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        if (searchTerm === '') {
            clearSearch();
            return;
        }

        // Show the loading state
        searchResults.innerHTML = '<div class="loading">Searching...</div>';
        searchResults.style.display = 'block';
        normalResults.style.display = 'none';
        paginationContainer.style.display = 'none';

        // Make an AJAX call to search across all users
        fetch(`<?= ROOT ?>/admin/searchUsers?term=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                searchResults.innerHTML = '';

                if (data.length === 0) {
                    searchResults.innerHTML = '<div class="no-results">No users found matching your search.</div>';
                    return;
                }

                // Create and append user elements
                data.forEach(user => {
                    if (user.roleID != 0 && user.roleID != 1) { // Exclude admin users
                        const userDiv = document.createElement('div');
                        userDiv.className = 'complaint container user-item';
                        userDiv.style.border = `2px solid ${user.activationCode ? 'green' : 'red'}`;

                        let roleName = 'Unknown';
                        if (user.roleID == 2) {
                            roleName = 'Individual';
                        } else if (user.roleID == 3) {
                            roleName = 'Organization';
                        }

                        userDiv.innerHTML = `
                            <div class="complaint-details flex-col">
                                <div class="complaint-details flex-row">
                                    <div class="the-complaint">
                                        <strong>Account ID:</strong> ${user.accountID}<br>
                                        <strong>Email:</strong> ${user.email}<br>
                                        <strong>Role:</strong> ${roleName}<br>
                                    </div>
                                    <div>
                                        <button class="btn btn-delete" onclick="confirmDelete('${user.accountID}')">Delete</button>
                                        <a href="<?php echo ROOT; ?>/admin/deactivateUser/${user.accountID}">
                                            <button style="background-color:brown;" class="btn btn-update">Deactivate</button>
                                        </a>
                                        <a href="<?php echo ROOT; ?>/admin/activateUser/${user.accountID}">
                                            <button style="background-color:green;" class="btn btn-update">Activate</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;

                        searchResults.appendChild(userDiv);
                    }
                });
            })
            .catch(error => {
                console.error('Error searching users:', error);
                searchResults.innerHTML = '<div class="no-results">An error occurred while searching. Please try again.</div>';
            });
    }

    function clearSearch() {
        searchInput.value = '';
        searchResults.style.display = 'none';
        normalResults.style.display = 'block';
        paginationContainer.style.display = 'flex';
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