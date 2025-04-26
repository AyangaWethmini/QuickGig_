<?php

class Home extends Controller
{
	protected $viewPath = "../app/views/home/";
	protected $planModel; //temporary for testig, needto move into a ad controller
	protected $adModel;

	public function __construct()
	{
		$this->adminModel = $this->model('AdminModel');
		$this->planModel = $this->model('Plans');
		$this->adModel = $this->model("Advertisement");
		$this->jobForHomeModel = $this->model("JobsForHome");
	}

	public function index()
	{
		$plans = $this->planModel->getPlans();
		$announcements = $this->adminModel->getAnnouncements();
		$advertisements = $this->adModel->getActiveAds();
		$announcements = $this->adminModel->getAnnouncements();
		$employeesForHome = $this->jobForHomeModel->getEmployees();
		$jobsForHome = $this->jobForHomeModel->getJobs();




		$data = [
			'plans' => $plans,
			'announcements' => $announcements,
			'jobs' => $jobsForHome,
			'advertisements' => $advertisements,
			'employees' => $employeesForHome

		];

		$this->view('home', $data);
	}

	public function signup()
	{
		$this->view('signup');
	}

	public function login()
	{
		$this->view('login');
	}
	public function nextSign()
	{
		$this->view('nextSign');
	}
	public function aboutUs()
	{
		$this->view('aboutUs');
	}


	public function contact()
	{
		$this->view('contact');
	}

	public function premium()
	{
		$data = $this->planModel->getPlansWithStripe();
		$this->view('premium', ['plans' => $data]);
	}

	public function advertise()
	{
		$this->view('advertise');
	}


	// public function payments()
	// {
	// 	$this->view('payments');
	// }

	public function subscriptions()
	{
		$data = $this->planModel->getPlans();
		$this->view('subscriptions', ['plans' => $data]);
	}


	public function sendEmail()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Sanitize input data
			$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
			$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
			$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

			// Validate inputs
			if (empty($name) || empty($email) || empty($message)) {
				echo "Please fill in all fields";
				return;
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo "Please enter a valid email address";
				return;
			}

			// Email configuration for MailHog
			$to = 'no-reply@quickgig.com';
			$subject = 'Contact Form Submission from ' . $name;
			$headers = "From: $email\r\n";
			$headers .= "Reply-To: $email\r\n";
			$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

			// Email body
			$body = "You have received a new message from your website contact form.\n\n";
			$body .= "Name: $name\n";
			$body .= "Email: $email\n\n";
			$body .= "Message:\n$message\n";

			// Use MailHog SMTP settings
			ini_set('SMTP', '127.0.0.1');
			ini_set('smtp_port', '1025');

			// Send email
			if (mail($to, $subject, $body, $headers)) {
				// echo "Thank you! Your message has been sent successfully.";
				$_SESSION['success'] = "Thank you! Your message has been sent successfully.";
				header("Location: " . ROOT . "/home/contact"); 
			} else {
				// echo "Oops! Something went wrong and we couldn't send your message.";
				$_SESSION['error'] = "Oops! Something went wrong and we couldn't send your message.";
				header("Location: " . ROOT . "/home/contact");
			}
		} else {
			echo "Invalid request method";
		}
	}
	}
