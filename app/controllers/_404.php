<?php 


class _404 extends Controller{
	
	public function index($message = "Page not found")
	{
		$this->view('error/404', ["message" => $message]);
	}
}