<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_complaints.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="complaints-grid">
            <!-- Pending Complaints Section -->
            <div class="complaints-section">
                <h2>Pending Complaints</h2>
                <div class="complaints-scroll">
                    <?php
                    $hasPendingComplaints = false;
                    foreach ($data['complaints'] as $complaint):
                        if ((int)$complaint->complaintStatus === 1):
                            $hasPendingComplaints = true;
                    ?>
                            <div class="complaint enhanced-complaint" onclick="showComplaintPopup('<?php echo htmlspecialchars($complaint->complaintID) ?>')">
                                <div class="complaint-content">
                                    <div class="complaint-text"><?php echo $complaint->content ?></div>
                                    <div class="complaint-time">
                                        <?php
                                        $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                        echo $complaint->complaintDate . ' | ' . $formattedTime;
                                        ?>
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
            </div>

            <!-- Reviewed Complaints Section -->
            <div class="complaints-section">
                <h2>Reviewed Complaints</h2>
                <div class="complaints-scroll">
                    <?php
                    $hasReviewedComplaints = false;
                    foreach ($data['complaints'] as $complaint):
                        if ((int)$complaint->complaintStatus === 3):
                            $hasReviewedComplaints = true;
                    ?>
                            <div class="complaint enhanced-complaint">
                                <div class="complaint-content">
                                    <div class="complaint-text"><?php echo $complaint->content ?></div>
                                    <div class="complaint-time">
                                        <?php
                                        $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                        echo $complaint->complaintDate . ' | ' . $formattedTime;
                                        ?>
                                    </div>
                                    <button onclick="dismissComplaint('<?php echo htmlspecialchars($complaint->complaintID) ?>')" class="dismiss-btn">Dismiss</button>
                                </div>
                            </div>
                        <?php
                        endif;
                    endforeach;

                    if (!$hasReviewedComplaints):
                        ?>
                        <div class="no-complaints">No reviewed complaints</div>
                    <?php endif; ?>
                </div>
            </div>
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
        complaintToDelete = complaintId || currentComplaintId;

        if (!complaintToDelete) {
            console.error('No complaint ID available');
            return;
        }

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
                    status: 2
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopup();
                    closeDismissPopup();
                    location.reload();
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

<style>
    .complaints-title {
        font-size: 3rem;
        font-weight: bold;
        color: #25324B;
        margin-bottom: 25px;
    }

    .complaints-section {
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .complaints-section h2 {
        font-size: 1.8rem;
        color: #4640DE;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
    }

    .complaints-scroll {
        padding-right: 15px;
    }

    .complaints-scroll::-webkit-scrollbar {
        width: 10px;
    }

    .complaints-scroll::-webkit-scrollbar-track {
        background: #f5f6fa;
        border-radius: 6px;
    }

    .complaints-scroll::-webkit-scrollbar-thumb {
        background: #4640DE;
        border-radius: 6px;
    }

    .complaints-scroll::-webkit-scrollbar-thumb:hover {
        background: #372ebf;
    }

    .enhanced-complaint {
        width: 95% !important;
        margin: 0 auto 20px auto;
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        min-height: 120px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #4640DE;
        transition: all 0.3s ease;
    }

    .enhanced-complaint:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .complaint-text {
        font-size: 1.4rem;
        line-height: 1.6;
        color: #333;
        max-height: none;
        margin-bottom: 30px;
    }

    .complaint-time {
        font-size: 1.1rem;
        color: #666;
        font-style: italic;
    }

    .dismiss-btn {
        font-size: 1rem;
        padding: 8px 15px;
        height: auto;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dismiss-btn:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
    }

    .no-complaints {
        font-size: 1.2rem;
        padding: 30px;
        border-radius: 12px;
        background-color: #f8f9fa;
        text-align: center;
        color: #6c757d;
    }

    @media (max-width: 1200px) {
        .complaints-grid {
            gap: 30px;
        }

        .complaints-section {
            height: auto;
            min-height: 500px;
        }
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>