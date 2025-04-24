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
		$this->adminModel = $this->model("AdminModel");
	}

	public function index()
	{
		$plans = $this->planModel->getPlans();
		$announcements = $this->adminModel->getAnnouncements();
		$advertisements = $this->adModel->getActiveAds();
		$announcements = $this->adminModel->getAnnouncements();


		$data = [
			'plans' => $plans,
			'announcements' => $announcements,
			'advertisements' => $advertisements

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
}
