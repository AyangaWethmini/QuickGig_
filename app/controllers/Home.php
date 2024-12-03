<?php

class Home extends Controller
{
	public function __construct()
	{
		$this->adminModel = $this->model('AdminModel');
	}

	protected $viewPath = "../app/views/home/";

	public function index()
	{
		// Fetch announcements from the database
		$announcements = $this->adminModel->getAnnouncements();

		// Ensure the announcements key is always defined
		$data = [
			'announcements' => $announcements
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
}
