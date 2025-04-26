<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/messages.css">

<body>

    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
        <div class="admin-container">
            <div class="admin-announcement-header">
                <h1>Current Announcements</h1>
            </div>
            <br>
            <hr>

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
                <div class="pagination-container">
                    <div class="pagination">
                        <!-- Always show Previous button -->
                        <a href="<?= ROOT ?>/jobProvider/announcements?page=<?= max(1, ($data['currentPage'] ?? 1) - 1) ?>"
                            class="page-link <?= ($data['currentPage'] ?? 1) <= 1 ? 'disabled' : '' ?>">
                            &laquo;
                        </a>

                        <!-- Always show page numbers -->
                        <?php for ($i = 1; $i <= max(1, $data['totalPages'] ?? 1); $i++): ?>
                            <a href="<?= ROOT ?>/jobProvider/announcements?page=<?= $i ?>"
                                class="page-link <?= $i == ($data['currentPage'] ?? 1) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <!-- Always show Next button -->
                        <a href="<?= ROOT ?>/jobProvider/announcements?page=<?= min($data['totalPages'] ?? 1, ($data['currentPage'] ?? 1) + 1) ?>"
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
            width: calc(100% - 320px);
            margin-left: 310px;
        }

        .wrapper {
            display: flex;
            position: relative;
        }

        .wrapper .sidebar {
            position: fixed;
            width: 300px;
        }

        .admin-announcement-header {
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .admin-announcement-header h1 {
            font-size: 28px;
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .complaints-container {
            flex: 1;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 60px;
            width: 90%;
            margin: 0 auto;
        }

        .complaint.container {
            margin: 0;
            width: 100%;
            border-radius: 6px;
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #4e73df;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .complaint.container:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        .complaint-content {
            position: relative;
            min-height: 120px;
            padding: 20px 25px 40px;
        }

        .complaint-details {
            display: flex;
            width: 100%;
        }

        .complaint-text {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .the-complaint {
            font-size: 28px;
            line-height: 1.6;
            color: #3a3b45;
            margin-bottom: 10px;
            font-weight: 400;
        }

        .text-grey {
            position: absolute;
            bottom: 15px;
            left: 25px;
            font-size: 18px;
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
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 80%;
        }

        .no-data-img {
            width: 50%;
            height: auto;
            margin-bottom: 15px;
            opacity: 0.7;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .admin-container {
                width: 100%;
                margin-left: 10px;
            }
        }
    </style>
</body>