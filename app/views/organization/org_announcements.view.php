<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([3]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/messages.css">

<body>

    <div class="wrapper flex-row">

        <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>

        <div class="admin-container">
            <div class="admin-announcement-header">
                <h1>Current Announcements</h1>
            </div>
            <br>
            <hr>

            <div class="complaints-container container">
                <?php if (empty($data['announcements'])): ?>
                    <div class="no-results">
                        No announcements found.
                    </div>
                <?php else: ?>
                    <?php foreach ($data['announcements'] as $announcement): ?>
                        <div class="complaint container">
                            <div class="complaint-content flex-col">
                                <div class="complaint-details flex-row">
                                    <div class="complaint-text flex-col">
                                        <div class="the-complaint"><?php echo $announcement->content; ?></div>
                                        <div class="text-grey">
                                            <?php
                                            $formattedTime = date('h:i A', strtotime($announcement->announcementTime));
                                            echo $announcement->announcementDate . ' | ' . $formattedTime;
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="pagination-container">
                <div class="pagination">
                    <!-- Always show Previous button -->
                    <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= max(1, $data['currentPage'] - 1) ?>"
                        class="page-link <?= $data['currentPage'] <= 1 ? 'disabled' : '' ?>">
                        &laquo;
                    </a>

                    <!-- Always show page numbers -->
                    <?php for ($i = 1; $i <= max(1, $data['totalPages']); $i++): ?>
                        <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= $i ?>"
                            class="page-link <?= $i == $data['currentPage'] ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Always show Next button -->
                    <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= min($data['totalPages'], $data['currentPage'] + 1) ?>"
                        class="page-link <?= $data['currentPage'] >= $data['totalPages'] ? 'disabled' : '' ?>">
                        &raquo;
                    </a>
                </div>
                <div class="pagination-info">
                    (Total announcements: <?= $data['totalAnnouncements'] ?>)
                </div>
            </div>
        </div>

    </div>

    <style>
        .admin-container {
            position: relative;
            min-height: 600px;
            padding-bottom: 100px;
        }

        .complaints-container {
            flex: 1;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 60px;
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
            margin: 0;
            background-color: #F9F9F9;
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

        .complaint.container {
            margin: 0;
            width: 100%;
        }

        .no-results {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 16px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>

</body>