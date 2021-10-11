<?php
defined('BASEPATH') or exit('No se permite acceso directo');
/**
 * StudentModel Class is extend with parent class of Model where we can execute database queries by model. 
 * function insertAnswer() in this function we are inserting student answer inside student_answers table into   database.
 * function getQuestion() in this function we are getting the all the questions for student to give their
   answers.
 * function checkAnswerExistenceById() in this function we are checking the existing of given question answer.
 * function studentQuestionAnswer() in this function we are checking student has given answer or not for the      particular question.
 * function updateAnswer() in this function we are updating student when given the answer of question.
 */
class StudentModel extends Model
{
  
  public function __construct()
  {
    parent::__construct();
  }

  
  public function insertAnswer($question_id,$answer,$studentName)
  {
    return $this->db->query("INSERT INTO `student_answers` (`question_answer_id`,`student_answer`,`student_name`) VALUES ('".$question_id."','".$answer."','".$studentName."')");
  }
  public function getQuestion(){
	  
	   $query = $this->db->query("SELECT * FROM `question_answers` ORDER BY `id` DESC");//->fetch_array(MYSQLI_ASSOC);
	   $resultArray = [];
	   while($result = $query->fetch_array(MYSQLI_ASSOC)){
		  $resultArray[] =  $result;
		   
	   }
	   return $resultArray;
  }
  
  
  public function checkAnswerExistenceById($id){
	   $query = $this->db->query("SELECT * FROM `student_answers` WHERE `id` = ".$id)->num_rows;
	   return $query;
  }
  
  
  public function studentQuestionAnswer(){
	  
	  
	  $userName = (!empty($_SESSION['userJointTest'])?$_SESSION['userJointTest']:'');
	   $query = $this->db->query('SELECT student_answers.id as QuestionAnswerId,student_answers.*,question_answers.* FROM `question_answers` JOIN student_answers ON question_answers.id = student_answers.question_answer_id  WHERE student_answers.student_name = "'.$userName.'"  ORDER BY question_answers.id DESC');//->fetch_array(MYSQLI_ASSOC);
	   $resultArray = [];
	   
	   
	   while($result = $query->fetch_array(MYSQLI_ASSOC)){
		  $resultArray[] =  $result;
		   
	   }
	   return $resultArray;
  }
  public function getQuestionbyId($id){
	  
	   $query = $this->db->query("SELECT * FROM `question_answers` WHERE `id` = ".$id);
	   return $query->fetch_array(MYSQLI_ASSOC);
	  
  }
  
  public function updateAnswer($student,$questionId,$answerId,$answerStr){
  	$query = $this->db->query("UPDATE `student_answers` SET 
									  `student_answer` = '$answerStr' 
									  WHERE `id` = '$answerId' && 
									  		`question_answer_id` = '$questionId' && 
											`student_name` = '$student'");
	return $query;
  }
 

}