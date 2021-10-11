<?php
defined('BASEPATH') or exit('No se permite acceso directo');

function getGivenAnswerByStudent($questId, $studentName)
{
	$mysql = new Mysqli(HOST, USER, PASSWORD, DB_NAME);
	
	$query = $mysql->query("SELECT * FROM `student_answers` WHERE `question_answer_id` = '$questId' AND `student_name` = '$studentName'")->num_rows;;
	return 	$query;
}