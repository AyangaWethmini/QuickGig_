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
            <?php
            $hasPendingComplaints = false;
            foreach ($data['complaints'] as $complaint):
                if ((int)$complaint->complaintStatus === 1):
                    $hasPendingComplaints = true;
            ?>
                    <div class="complaint container" onclick="showComplaintPopup('<?php echo htmlspecialchars($complaint->complaintID) ?>')">
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
                <?php
                endif;
            endforeach;

            if (!$hasPendingComplaints):
                ?>
                <div class="no-complaints">No pending complaints</div>
            <?php endif; ?>
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
                                <button onclick="dismissComplaint('<?php echo htmlspecialchars($complaint->complaintID) ?>')" class="dismiss-btn">Dismiss</button>
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
                    <button onclick="dismissFromPopup()" class="dismiss-btn">Dismiss</button>
                </div>
            </div>
        </div>

        <!-- Dismiss Confirmation Popup -->
        <div id="dismissConfirmPopup" class="popup">
            <div class="popup-content">
                <span class="close-popup" onclick="closeDismissPopup()">&times;</span>
                <h2>Confirm Dismissal</h2>
                <p>Are you sure you want to dismiss this complaint?</p>
                <div class="popup-buttons">
                    <button onclick="confirmDismiss()" class="dismiss-btn">Yes, Dismiss</button>
                    <button onclick="closeDismissPopup()" class="review-btn">Cancel</button>
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
        cursor: pointer;
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

    /* Add this to your existing CSS */
    .no-complaints {
        text-align: center;
        padding: 30px;
        color: #666;
        font-size: 16px;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin: 20px 0;
    }

    /* Add to your existing styles */
    #dismissConfirmPopup .popup-content {
        max-width: 400px;
        text-align: center;
    }

    #dismissConfirmPopup p {
        margin: 20px 0;
        font-size: 16px;
        color: #2c3e50;
        line-height: 1.5;
    }

    #dismissConfirmPopup .popup-buttons {
        justify-content: center;
        gap: 20px;
    }

    #dismissConfirmPopup .popup-buttons button {
        min-width: 120px;
    }

    #dismissConfirmPopup .review-btn {
        background-color: #95a5a6;
    }

    #dismissConfirmPopup .review-btn:hover {
        background-color: #7f8c8d;
    }

    /* For reviewed complaints that don't have the popup functionality */
    #reviewed-complaints .complaint {
        cursor: default;
    }

    /* But keep pointer cursor for the dismiss button in reviewed complaints */
    #reviewed-complaints .dismiss-btn {
        cursor: pointer;
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
        console.log('Fetching details for complaint:', complaintId);

        fetch(`<?php echo ROOT ?>/admin/getComplaintDetails/${complaintId}`)
            .then(response => {
                if (!response.ok) {
                    return response.json()
                        .then(err => Promise.reject(new Error(err.error || 'Failed to load complaint details')))
                        .catch(() => Promise.reject(new Error('Failed to load complaint details')));
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                const popup = document.getElementById('complaintPopup');
                const content = document.getElementById('popupContent');

                if (!data.complaint || !data.complainant || !data.complainee) {
                    throw new Error('Incomplete complaint data');
                }

                // Safely access nested properties
                const complaintData = {
                    content: data.complaint.content || 'No content available',
                    complainantEmail: data.complainant.email || 'No email available',
                    complaineeEmail: data.complainee.email || 'No email available',
                    date: data.complaint.complaintDate || 'No date available',
                    time: data.complaint.complaintTime || 'No time available'
                };

                content.innerHTML = `
                    <p><strong>Content:</strong> ${complaintData.content}</p>
                    <p><strong>Complainant Email:</strong> ${complaintData.complainantEmail}</p>
                    <p><strong>Complainee Email:</strong> ${complaintData.complaineeEmail}</p>
                    <p><strong>Date:</strong> ${complaintData.date}</p>
                    <p><strong>Time:</strong> ${complaintData.time}</p>
                `;

                popup.style.display = 'block';
                currentComplaintId = complaintId;
            })
            .catch(error => {
                console.error('Detailed error:', error);
                alert(error.message || 'Failed to load complaint details. Please try again later.');
            });
    }

    function closePopup() {
        document.getElementById('complaintPopup').style.display = 'none';
    }

    function markAsReviewed() {
        if (!currentComplaintId) {
            console.error('No complaint ID available');
            return;
        }

        fetch('<?php echo ROOT; ?>/admin/updateComplaintStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: currentComplaintId,
                    status: 3 // 3 for reviewed
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopup();
                    location.reload(); // Reload to update the lists
                } else {
                    alert('Failed to mark complaint as reviewed.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the complaint status.');
            });
    }

    let currentComplaintId = null;
    let complaintToDelete = null;

    function dismissComplaint(complaintId = null) {
        // Store the complaint ID to be dismissed
        complaintToDelete = complaintId || currentComplaintId;

        if (!complaintToDelete) {
            console.error('No complaint ID available');
            return;
        }

        // Show the confirmation popup
        document.getElementById('dismissConfirmPopup').style.display = 'block';
    }

    function closeDismissPopup() {
        document.getElementById('dismissConfirmPopup').style.display = 'none';
        complaintToDelete = null;
    }

    function confirmDismiss() {
        if (!complaintToDelete) {
            console.error('No complaint ID available');
            return;
        }

        fetch('<?php echo ROOT; ?>/admin/updateComplaintStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: complaintToDelete,
                    status: 2 // 2 for dismissed
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close both popups if they're open
                    closePopup();
                    closeDismissPopup();
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

    function dismissFromPopup() {
        dismissComplaint();
    }

    // Close popup when clicking outside
    window.onclick = function(event) {
        const popup = document.getElementById('complaintPopup');
        const dismissPopup = document.getElementById('dismissConfirmPopup');
        if (event.target === popup) {
            closePopup();
        }
        if (event.target === dismissPopup) {
            closeDismissPopup();
        }
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>