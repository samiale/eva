<?php
defined('BASEPATH') or exit('No se permite acceso directo');
require_once ROOT . '/qust_ans_portl/app/models/Teacher/TeacherModel.php';
/**
 * Teacher controller
 * We have a TeacherController Class Which is extended with parent Controller class for using of logical   	
   operation in project.
 * function __construct() this is called magic function which is automatically called when the class will be   
   executed this function does not need to be called manaully when any method will be called this magic.  
   function will be called automatically in this function we are loading our TeacherModel class. 
 * function exec() inside execute function we are rendering the view of template html contents by the help of 		   show function is being called inside exec() function.
 * function show() this function we are setting up our dynamic variable into view html templates these variable   will be sent into view folder files then we can easily price those variable data into view.
 * function index() in this function we are fetching teacher created question in this function.
 * function add_question() in this function we are adding question answer when teacher creates any question.
 */
class TeacherController extends Controller
{
  /**
   * string 
   */
  public $nombre;
  public $questionAnswers;
  /**
   * object 
   */
  public $model;

  
  public function __construct()
  {
	  
    $this->model = new TeacherModel();
	
  //  $this->nombre = 'Mundo';
  }

  
  public function exec()
  {header('Location: index');
    $this->show();
  }

  
  public function show()
  {
    $params = array('nombre' => $this->nombre,'questionAnswers' => $this->questionAnswers);
    $this->render(__CLASS__, $params); 
  }

  
  public function index($param)
  {
    $res = $this->model->getQuestion();
	
	$this->questionAnswers = $res;
    $this->show();
  }
  
  public function add_question(){
	  if(!empty($_POST) && !empty($_POST['submit']) && $_POST['submit'] == 'Submit'){
	  	  parse_str($_POST['data'],$Post);
	  	  $question = $_POST['parsequestion'];
		  $countpercentage = substr_count($question,"%");
		  if($countpercentage>1){
			  $countpercentage = ($countpercentage / 2);
			  $matched = '';
			  $answer = '';
			  $answerType = '';
			  for($l = 0; $l<$countpercentage;$l++){
				  if (preg_match('/%(.*?)%/', $question, $matched) == 1){
					  $answer .= $Post['answer'][$l].', ';
					  $answerType .= $Post['answerType'][$l].', ';
					  $question = str_replace($matched[0],'{'.$l.'}',$question);  
				  }  
			   }
			   $answerType = substr($answerType,0,-2);
			   $answer = substr($answer,0,-2); 
		   }
	   	   $inserted = $this->model->insertQuestion($question,$answer,$answerType);
		   if($inserted){
			   echo json_encode(['action'=>true]);
			   die();
		   }
		   else
		   {
			   echo json_encode(['action'=>false]);
			   die();
		   }
	  }
	}
}