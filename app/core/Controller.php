<?php 

class Controller
{

	protected $viewPath = "../app/views/";

	public function model($model) {
        // Require model file
        require_once '../app/models/' . $model . '.php';
        // Instantiate model
        return new $model();
    }
	
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