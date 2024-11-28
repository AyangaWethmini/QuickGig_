<?php
class Seeker extends Controller
{
    
    protected $viewPath = "../app/views/seeker/";
    
    function index()
    {
        $this->view('seekerProfile');
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
        $this->view('announcements');
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

    function complaints()
    {
        $this->view('complaints');
    }

    function settings()
    {
        $this->view('settings');
    }
    function updateJob()
    {
        $this->view('updateJob');
    }
    public function availability()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $availableID = uniqid();

            $accountID = $_SESSION['user_id'];

            $description = trim($_POST['description']);
            $location = trim($_POST['location']);
            $timeFrom = trim($_POST['timeFrom']);
            $timeTo = trim($_POST['timeTo']);
            $availableDate = trim($_POST['availableDate']);
            $shift = trim($_POST['shift']);
            $salary = trim($_POST['salary']);
            $currency = trim($_POST['currency']);

            $makeAvailableModel = $this->model('Available');
            $isPosted = $makeAvailableModel->create([
                'availableID' => $availableID,
                'accountID' => $accountID,
                'description' => $description,
                'timeFrom' => $timeFrom,
                'timeTo' => $timeTo,
                'location' => $location,
                'availableDate' => $availableDate,
                'shift' => $shift,
                'salary' => $salary,
                'currency' => $currency
            ]);

            // Redirect or handle based on success or failure
            if ($isPosted) {
                header('Location: ' . ROOT . '/seeker/jobListing_myJobs'); // Replace with the appropriate success page
                exit();
            } else {
                // Handle errors (e.g., log them or show an error message)
                echo "Failed to post availability. Please try again.";
            }
        }
    }
    public function updateAvailability($id = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Prepare data for updating
            $description = trim($_POST['description']);
            $shift = $_POST['shift'];
            $salary = trim($_POST['salary']);
            $currency = $_POST['currency'];
            $timeFrom = $_POST['timeFrom'];
            $timeTo = $_POST['timeTo'];
            $availableDate = $_POST['availableDate'];
            $location = trim($_POST['location']);
    
            // Update availability in the database
            $this->availabilityModel = $this->model('Available');
            $this->availabilityModel->update($id, [
                'description' => $description,
                'shift' => $shift,
                'salary' => $salary,
                'currency' => $currency,
                'timeFrom' => $timeFrom,
                'timeTo' => $timeTo,
                'availableDate' => $availableDate,
                'location' => $location
            ]);
    
            // Redirect to the availability page or another appropriate page
            header('Location: ' . ROOT . '/seeker/jobListing_myJobs');
        } else {
            // Get the current availability details for the given ID
            $this->availabilityModel = $this->model('Available');
            $availability = $this->availabilityModel->getAvailabilityById($id);
    
            // Pass the current availability data to the view
            $data = [
                'availability' => $availability
            ];
    
            // Load the update form view
            $this->view('updateJob', $data);
        }
    }
    public function deleteAvailability($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->availabilityModel = $this->model('Available');
            $this->availabilityModel->delete($id);
            header('Location: ' . ROOT . '/seeker/jobListing_myJobs');
        }
    }
    
    
}
