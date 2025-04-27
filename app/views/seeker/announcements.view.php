<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/messages.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/JobProvider/findEmployees.css">

<body>

    <div class="wrapper flex-row" style="background-color:#FFFFFF;">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
        <div class="admin-container">
            <div class="header">
                <div class="heading">Current Announcements</div>
            </div>

            <div class="complaints-container container">
                <?php if (empty($data['announcements'])): ?>
                    <div class="no-results">
                        <img src="<?= ROOT ?>/assets/images/no-announcement.png" alt="No Announcements" class="no-data-img">
                        <p style="font-size: 32px; color: #3599FF;"><strong>No announcements Yet.</strong></p>
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

            <?php if (!empty($data['announcements'])): ?>
                <div class="pagination-container" style="background-color:#FFFFFF;">
                    <div class="pagination">
                        <!-- Always show Previous button -->
                        <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= max(1, ($data['currentPage'] ?? 1) - 1) ?>"
                            class="page-link <?= ($data['currentPage'] ?? 1) <= 1 ? 'disabled' : '' ?>">
                            &laquo;
                        </a>

                        <!-- Always show page numbers -->
                        <?php for ($i = 1; $i <= max(1, $data['totalPages'] ?? 1); $i++): ?>
                            <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= $i ?>"
                                class="page-link <?= $i == ($data['currentPage'] ?? 1) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Always show Next button -->
                        <a href="<?= ROOT ?>/admin/adminannouncement?page=<?= min($data['totalPages'] ?? 1, ($data['currentPage'] ?? 1) + 1) ?>"
                            class="page-link <?= ($data['currentPage'] ?? 1) >= ($data['totalPages'] ?? 1) ? 'disabled' : '' ?>">
                            &raquo;
                        </a>
                    </div>
                    <div class="pagination-info">
                        (Total announcements: <?= $data['totalAnnouncements'] ?? 0 ?>)
                    </div>
                </div>
            <?php endif; ?>
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

        .complaint.container {
            margin: 0;
            width: 100%;
            border-radius: 6px;
            background-color: #ffffff;
            background: linear-gradient(135deg, #e0f0ff, #f0e8ff);
            /* box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .complaint.container:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        .complaint-content {
            position: relative;
            min-height: 100px;
            padding: 10px 15px 30px;
        }

        .complaint-details {
            display: flex;
            width: 100%;
        }

        .the-complaint {
            font-size: 24px;
            line-height: 1.6;
            color: #3a3b45;
            margin-bottom: 10px;
            font-weight: 400;
        }

        .text-grey {
            position: absolute;
            bottom: 15px;
            left: 25px;
            font-size: 14px;
            margin-top: auto;
            text-align: left;
            color: #858796;
            font-style: italic;
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

        .no-results {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 24px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .no-data-img {
            width: 50%;
            height: auto;
            margin-bottom: 15px;
            opacity: 0.7;
        }
    </style>
</body>