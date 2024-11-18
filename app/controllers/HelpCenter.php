<?php 

class HelpCenter extends Controller
{
	protected $viewPath = "../app/views/";

	public function index()
	{
		$this->view('helpCenter');
	}

	
}
