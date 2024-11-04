<?php 

class Home extends Controller
{
	protected $viewPath = "../app/views/home/";

	public function index()
	{
		$this->view('home');
	}

}
