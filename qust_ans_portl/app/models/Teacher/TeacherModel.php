<?php
defined('BASEPATH') or exit('No se permite acceso directo');
/**
 * Teacher Model

 * TeacherModel Class is extend with parent class of Model where we can execute database queries by model. 
 * function insertQuestion() in this function we are inserting Question inside question_answers table into   
   database.
 * function getQuestion() in this function we are getting the all the questions answer  for teacher panel.
 */
 
class TeacherModel extends Model
{
  
  public function __construct()
  {
    parent::__construct();
  }


  public function insertQuestion($question,$answer,$answerType)
  {
    return $this->db->query('INSERT INTO `question_answers` (`question`,`answer`,`answer_type`) VALUES ("'.$question.'","'.$answer.'","'.$answerType.'")');
  }
  
  public function getQuestion(){
	  
	   $query = $this->db->query("SELECT * FROM `question_answers` ORDER BY `id` DESC");
	   $resultArray = [];
	   while($result = $query->fetch_array(MYSQLI_ASSOC)){
		  $resultArray[] =  $result;
		   
	   }
	   return $resultArray;
  }

}