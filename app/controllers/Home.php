<?php 

class Home extends Controller
{
	protected $viewPath = "../app/views/home/";

	public function index()
	{
		$this->view('home');
	}

	public function signup()
	{
		$this->view('signup');
	}

	public function login()
	{
		$this->view('login');
	}
}
