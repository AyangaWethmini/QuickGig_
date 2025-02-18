<?php
class JobProvider extends Controller
{

    public function __construct()
    {
        $this->complaintModel = $this->model('Complaint');
        $this->adminModel = $this->model('AdminModel');
        $this->accountModel = $this->model('Account');
    }

    protected $viewPath = "../app/views/jobProvider/";

    function index()
    {
        $this->view('individualProfile');
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $oldPassword = trim($_POST['oldpw']);
            $newPassword = trim($_POST['newpw']);
            $reNewPassword = trim($_POST['renewpw']);
            $accountID = $_SESSION['user_id']; // Assuming user ID is stored in session

            // Validate if new passwords match
            if ($newPassword !== $reNewPassword) {
                // flash('password_message', 'New passwords do not match!', 'alert-danger');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            }

            // Fetch the current password from the database
            $currentUser = $this->accountModel->getUserByID($accountID);

            if (!password_verify($oldPassword, $currentUser->password)) {
                // flash('password_message', 'Old password is incorrect!', 'alert-danger');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            }

            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password in the database
            if ($this->accountModel->changePassword($accountID, $hashedPassword)) {
                // flash('password_message', 'Password updated successfully!', 'alert-success');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            } else {
                // flash('password_message', 'Something went wrong, please try again.', 'alert-danger');
                header('Location: ' . ROOT . '/jobProvider/settings');
                exit;
            }
        } else {
            header('Location: ' . ROOT . '/jobProvider/settings');
            exit;
        }
    }

    function findEmployees()
    {
        $this->view('findEmployees');
    }

    function postJob()
    {
        $this->view('postJob');
    }

    function jobListing_received()
    {
        $this->view('jobListing_received');
    }

    function viewEmployeeProfile()
    {
        $this->view('viewEmployeeProfile');
    }

    function subscription()
    {
        $this->view('subscription');
    }

    function messages()
    {
        $this->view('messages');
    }

    function announcements()
    {

        $announcements = $this->adminModel->getAnnouncements();

        $data = [
            'announcements' => $announcements
        ];
        $this->view('announcements', $data);
    }

    function individualEditProfile()
    {
        $this->view('individualEditProfile');
    }

    function helpCenter()
    {
        $this->view('helpCenter');
    }

    function reviews()
    {
        $this->view('reviews');
    }

    function jobListing_myJobs()
    {
        $this->view('jobListing_myJobs');
    }

    function jobListing_send()
    {
        $this->view('jobListing_send');
    }

    function jobListing_toBeCompleted()
    {
        $this->view('jobListing_toBeCompleted');
    }

    function jobListing_ongoing()
    {
        $this->view('jobListing_ongoing');
    }

    function jobListing_completed()
    {
        $this->view('jobListing_completed');
    }

    function makeComplaint()
    {
        $this->view('makeComplaint');
    }

    function submitComplaint()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $complainantID = $_SESSION['user_id'];
            $content = trim($_POST['complainInfo']);
            $complaintDate = date('Y-m-d');
            $complaintTime = date('h:i A');
            $complaintStatus = 1;

            $complaintModel = $this->model('Complaint');
            $complaintModel->create([
                'complainantID' => $complainantID,
                'content' => $content,
                'complaintDate' => $complaintDate,
                'complaintTime' => $complaintTime,
                'complaintStatus' => $complaintStatus
            ]);

            header('Location: ' . ROOT . '/jobProvider/jobListing_completed');
        }
    }



    function complaints()
    {
        $complaints = $this->complaintModel->getComplaints();

        $data = [
            'complaints' => $complaints
        ];

        $this->view('complaints', $data);
    }

    public function deleteComplaint($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->complaintModel->delete($id);
            header('Location: ' . ROOT . '/jobProvider/complaints');
        }
    }

    public function updateComplaint($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = trim($_POST['complainInfo']);
            $complaintDate = date('Y-m-d');
            $complaintTime = date('h:i A');

            $this->complaintModel->update($id, [
                'content' => $content,
                'complaintDate' => $complaintDate,
                'complaintTime' => $complaintTime
            ]);

            header('Location: ' . ROOT . '/jobProvider/complaints');
        } else {
            $complaint = $this->complaintModel->getComplaintById($id);

            $data = [
                'complaint' => $complaint
            ];

            $this->view('updateComplaint', $data);
        }
    }

    function settings()
    {
        $this->view('settings');
    }
}
