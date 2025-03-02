<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <h1>All Complaints</h1>

        <div class="admin-announcement-filterheader">
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('pending')">Pending</button>
                <button class="tab-btn" onclick="showTab('reviewed')">Reviewed</button>
            </div>
        </div>
        <hr>
        <!-- Pending Complaints Tab -->
        <div id="pending-complaints" class="complaints-container container tab-content active">
            <?php foreach ($data['complaints'] as $complaint): ?>
                <?php if ((int)$complaint->complaintStatus == 1): ?>
                    <div class="complaint container" onclick="showComplaintPopup('<?php echo $complaint->complaintID ?>')">
                        <div class="complaint-details flex-col">
                            <div class="complaint-details flex-row">
                                <div class="the-complaint"><?php echo $complaint->content ?></div>
                                <div class="text-grey">
                                    <?php
                                    $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                    echo $complaint->complaintDate . ' | ' . $formattedTime;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Reviewed Complaints Tab -->
        <div id="reviewed-complaints" class="complaints-container container tab-content">
            <?php foreach ($data['complaints'] as $complaint): ?>
                <?php if ((int)$complaint->complaintStatus == 3): ?>
                    <div class="complaint container">
                        <div class="complaint-details flex-col">
                            <div class="complaint-details flex-row">
                                <div class="the-complaint"><?php echo $complaint->content ?></div>
                                <div class="text-grey">
                                    <?php
                                    $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                    echo $complaint->complaintDate . ' | ' . $formattedTime;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Complaint Popup -->
        <div id="complaintPopup" class="popup">
            <div class="popup-content">
                <span class="close-popup" onclick="closePopup()">&times;</span>
                <h2>Complaint Details</h2>
                <div id="popupContent"></div>
                <div class="popup-buttons">
                    <button onclick="markAsReviewed()" class="review-btn">Mark as Reviewed</button>
                    <button onclick="dismissComplaint()" class="dismiss-btn">Dismiss</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Header and Tab Styling */
    .admin-announcement-filterheader {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        margin: 20px 0;
    }

    .admin-announcement-filterheader h1 {
        font-size: 2rem;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .tabs {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
        width: 100%;
    }

    .tab-btn {
        padding: 12px 35px;
        border: none;
        background-color: #f5f6fa;
        color: #2c3e50;
        cursor: pointer;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .tab-btn:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
    }

    .tab-btn.active {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    /* Tab Content Styling */
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Complaints Container Styling */
    .complaints-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .complaint {
        background-color: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #eee;
    }

    .complaint:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        border-color: #e0e0e0;
    }

    .complaint-details.flex-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .the-complaint {
        font-size: 16px;
        color: #2c3e50;
        line-height: 1.6;
        flex-grow: 1;
    }

    .text-grey {
        color: #7f8c8d;
        font-size: 14px;
        font-weight: 500;
    }

    /* Popup Styling */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        backdrop-filter: blur(5px);
    }

    .popup-content {
        position: relative;
        background-color: white;
        margin: 8% auto;
        padding: 35px;
        width: 90%;
        max-width: 600px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        animation: popupFade 0.3s ease-out;
    }

    @keyframes popupFade {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .close-popup {
        position: absolute;
        right: 25px;
        top: 20px;
        font-size: 28px;
        color: #95a5a6;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .close-popup:hover {
        background-color: #f8f9fa;
        color: #e74c3c;
    }

    .popup-content h2 {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f2f5;
    }

    #popupContent {
        margin: 25px 0;
    }

    #popupContent p {
        margin: 15px 0;
        line-height: 1.8;
        color: #34495e;
        padding: 10px 0;
        border-bottom: 1px solid #f5f6fa;
    }

    #popupContent p:last-child {
        border-bottom: none;
    }

    #popupContent strong {
        color: #2c3e50;
        font-weight: 600;
        margin-right: 10px;
    }

    .popup-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f2f5;
    }

    .review-btn,
    .dismiss-btn {
        flex: 1;
        padding: 14px 25px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .review-btn {
        background-color: #2ecc71;
        color: white;
    }

    .review-btn:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }

    .dismiss-btn {
        background-color: #e74c3c;
        color: white;
    }

    .dismiss-btn:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .complaint-details.flex-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .text-grey {
            margin-top: 10px;
        }

        .popup-content {
            margin: 5% auto;
            padding: 25px;
            width: 95%;
        }

        .popup-buttons {
            flex-direction: column;
        }

        .review-btn,
        .dismiss-btn {
            width: 100%;
        }
    }
</style>

<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Show selected tab content and activate button
        document.getElementById(tabName + '-complaints').classList.add('active');
        event.currentTarget.classList.add('active');
    }

    function showComplaintPopup(complaintId) {
        fetch(`<?php echo ROOT ?>/admin/getComplaintDetails/${complaintId}`)
            .then(response => response.json())
            .then(data => {
                const popup = document.getElementById('complaintPopup');
                const content = document.getElementById('popupContent');

                content.innerHTML = `
                    <p><strong>Content:</strong> ${data.complaint.content}</p>
                    <p><strong>Complainant Email:</strong> ${data.complainant.email}</p>
                    <p><strong>Complainee Email:</strong> ${data.complainee.email}</p>
                    <p><strong>Date:</strong> ${data.complaint.complaintDate}</p>
                    <p><strong>Time:</strong> ${data.complaint.complaintTime}</p>
                `;

                popup.style.display = 'block';
                currentComplaintId = complaintId;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load complaint details');
            });
    }

    function closePopup() {
        document.getElementById('complaintPopup').style.display = 'none';
    }

    function markAsReviewed() {
        updateComplaintStatus(3); // 3 for reviewed
    }

    function dismissComplaint() {
        updateComplaintStatus(2); // 2 for dismissed
    }

    function updateComplaintStatus(status) {
        fetch('<?php echo ROOT; ?>/admin/updateComplaintStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: currentComplaintId,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopup();
                    location.reload(); // Reload to update the lists
                } else {
                    alert('Failed to update complaint status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the complaint status.');
            });
    }

    let currentComplaintId = null;

    // Close popup when clicking outside
    window.onclick = function(event) {
        const popup = document.getElementById('complaintPopup');
        if (event.target === popup) {
            closePopup();
        }
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>