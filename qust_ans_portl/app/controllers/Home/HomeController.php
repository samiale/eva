<?php
defined('BASEPATH') or exit('No se permite acceso directo');
require_once ROOT . '/qust_ans_portl/app/models/Home/HomeModel.php';
/**
 * Home controller
 */
class HomeController extends Controller
{
  /**
   * string 
   */
  public $nombre;

  /**
   * object 
   */
  public $model;

 
  public function __construct()
  {
	  header('Location: student/index');
    
  }

  
  public function exec()
  {
    $this->show();
  }

  
  public function show()
  {
    $params = array('nombre' => $this->nombre);
    $this->render(__CLASS__, $params); 
  }


}