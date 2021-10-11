<?php
defined('BASEPATH') or exit('No se permite acceso directo');

/**
 * We have a StudentController Class Which is extended with Controller
 * this is controller we have Student Model Where we perform Database Related things.
 * function __construct() this is called magic function which is automatically called when the class will be   
   executed this function does not need to be called manaully when any method will be called this magic. 
 * function exec() inside execute function we are rendering the view of template html contents by the help of 		   show function is being called inside exec() function.
 * function show() this function we are setting up our dynamic variable into view html templates these variable   will be sent into view folder files then we can easily price those variable data into view.
 * function index() inside this function we are fetching the student question which was assigned by the teacher   and also fetching user given question in this function.
 * function add_answer() in this function when student write his answer and press submit button then those data   will be stored into database by the help of this function.
 * function edit_answer() inside this function student can edit his given answer when user change something 	   inside edit in question answer then this function will edit questions answers.
 * function write_user_session() inside this function when student will write his name then system identitfy  
   the student who is giving answer to the question this question write the data in session for that particular   student who is giving answer.
 * function destory_user_session() in this function user can delete his session when he has given his question    and answer then he will logout himself in test session this function help in it.
 */
require_once ROOT . '/qust_ans_portl/app/models/Student/StudentModel.php';
/**
 * Teacher controller
 */
class StudentController extends Controller
{
  /**
   * string 
   */
  public $nombre;
  public $questionAnswers;
  public $studentQuestionAnswer;
  /**
   * object 
   */
  public $model;

  
  public function __construct()
  {
	  session_start();
    $this->model = new StudentModel();

  }

 
  public function exec()
  {
    $this->show();
  }

 
  public function show()
  {
	  
    $params = array('nombre' => $this->nombre,
					'questionAnswers' => $this->questionAnswers,
					'studentQuestionAnswer'=> $this->studentQuestionAnswer);
    $this->render(__CLASS__, $params); 
  }

 
  public function index($param)
  {
    $res = $this->model->getQuestion();
	$this->studentQuestionAnswer = $this->model->studentQuestionAnswer();
	$this->questionAnswers = $res;
    $this->show();
  }
  
  public function add_answer(){
	  
	  if(!empty($_POST) && !empty($_POST['submit']) && $_POST['submit'] == 'Submit'){
		  $getQuestion = $this->model->getQuestionbyId($_POST['question_id']);
		  $mergeAnswer = '';
		  foreach($_POST['answer'] as $answer){
			  $mergeAnswer .= $answer.', ';
			
		  }
		  $mergeAnswer = substr($mergeAnswer,0,-2);
		  $inserted = $this->model->insertAnswer($_POST['question_id'],$mergeAnswer,$_SESSION['userJointTest']);
		   if($inserted){
			   header('Location: index');
		   }
	  }
	  
  }
  
  public function edit_answer(){
	   if($this->model->checkAnswerExistenceById($_POST['questanswerId']) > 0)
	   {
		   $mergeAnswer = '';
		  foreach($_POST['answer'] as $answer){
			  $mergeAnswer .= $answer.', ';
			
		  }
		  $mergeAnswer = substr($mergeAnswer,0,-2);
		   $studentName = $_SESSION['userJointTest'];
		  $updated = $this->model->updateAnswer($studentName,$_POST['questionId'],$_POST['questanswerId'],$mergeAnswer);
		  if($updated){
	   		 header('Location: index');
		  }
	   }
  }
  
  public function write_user_session(){
	 if(!empty($_POST) && !empty($_POST['submit']) && $_POST['submit'] == 'Submit'){
	  	$_SESSION['userJointTest'] = $_POST['student_name'];
	 }
	 header('Location: index');

  }
  
  public function destory_user_session(){
	 if($_SESSION['userJointTest'])
	 {
		 session_destroy();
	 }
	 header('Location: index');

  }
  
  


}