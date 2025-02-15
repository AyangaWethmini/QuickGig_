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
	public function nextSign()
	{
		$this->view('nextSign');
	}
	public function aboutUs()
	{
		$this->view('aboutUs');
	}

	public function payments()
	{
		$this->view('payments');
	}
}
