<?php

class Home extends Controller
{
	public function __construct()
	{
		$this->adminModel = $this->model('AdminModel');
		$this->planModel = $this->model('Plans');
	}

	protected $viewPath = "../app/views/home/";
	protected $planModel; //temporary for testig, needto move into a ad controller

	public function index()
	{
		$plans = $this->planModel->getPlans();
		// Fetch announcements from the database
		$announcements = $this->adminModel->getAnnouncements();

		// Ensure the announcements key is always defined
		$data = [
			'announcements' => $announcements,
			'plans' => $plans
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

	// public function payments()
	// {
	// 	$this->view('payments');
	// }

	// public function subscriptions()
	// {
	// 	$data = $this->planModel->getPlans();
	// 	$this->view('subscriptions', ['plans' => $data]);
	// }
}
