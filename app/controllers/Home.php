<?php 

class Home extends Controller
{
	protected $viewPath = "../app/views/home/";

	public function index()
	{
		$this->adminModel = $this->model('AdminModel');
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
		
	}	
}
