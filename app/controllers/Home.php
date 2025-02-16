<?php

class Home extends Controller
{
	protected $viewPath = "../app/views/home/";
	protected $planModel; //temporary for testig, needto move into a ad controller

	public function __construct()
	{
		$this->planModel = $this->model('Plans');
	}

	public function index()
	{
		$data = $this->planModel->getPlans();
		$this->view('home',['plans' => $data]);
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
