<?php

class Home extends Controller
{
	protected $viewPath = "../app/views/home/";
	protected $planModel; //temporary for testig, needto move into a ad controller
	protected $adModel;

	public function __construct()
	{
		// $this->adminModel = $this->model('AdminModel');
		$this->planModel = $this->model('Plans');
		$this->adModel = $this->model("Advertisement");
	}

	public function index()
	{
		$plans = $this->planModel->getPlans();
<<<<<<< HEAD
		$ad = $this->adModel->getRandomActiveAd();
		$announcememts = $this->adminModel->getAnnouncements();

		$data = [
			'plans' => $plans,
			'ad' => $ad,
			'announcements' => $announcememts
=======
		$advertisements = $this->adModel->getActiveAds();

		$data = [
			'plans' => $plans,
			'advertisements' => $advertisements
>>>>>>> AyangaW
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
