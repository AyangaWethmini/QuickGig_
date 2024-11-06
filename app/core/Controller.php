<?php 

class Controller
{

	protected $viewPath = "../app/views/";
	
	public function view($name, $data = [])
	{
		$filename = $this->viewPath.$name.".view.php";
		if(file_exists($filename))
		{
			extract($data);
			require $filename;
		}else{
			$this->view('error/404', ["message" => "View not found"]);
		}
	}
}