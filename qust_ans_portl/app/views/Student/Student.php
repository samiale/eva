<?php defined('BASEPATH') or exit('No se permite acceso directo'); 

function sort_question_answer($question, $answer,$answer_type)
{
	$explode_question = explode(" ",$question);
	$explode_answer = explode(",",$answer);
	$question_ans = [];
	$question_ans_string = "";
	$explode_answer_type = explode(",",$answer_type);
	$answerTypelable = '';
	foreach($explode_question as $quest)
	{	
		$question_ans_string .= $quest." ";
		foreach($explode_answer as $k => $v)
		{
			if(substr_count($quest,'{'.$k.'}'))
			{
				switch($explode_answer_type[$k]){
					case 1:
					$answerTypelable = 'Expression';
					break;
					case 2:
					$answerTypelable = 'Mot';
					break;
					default:
					$answerTypelable = '';
					break;
				}
				$question_ans_string = str_replace('{'.$k.'}',' <input type="text" id="question"  style="width:100px" placeholder="Votre Réponse" data-toggle="tooltip" data-placement="top" title="'.$answerTypelable.'" name="answer[]" required> ',$question_ans_string);
				$question_ans[$k] = $question_ans_string.' ';
			}else{
				$question_ans[$k] = $question_ans_string.' ';
				
			}
		}
	}
	return end($question_ans);
}

function sort_question_answer_show($question, $answer)
{
	$explode_question = explode(" ",$question);
	$explode_answer = explode(",",$answer);
	$question_ans = [];
	$question_ans_string = "";
	foreach($explode_question as $quest)
	{	
		$question_ans_string .= $quest." ";
		foreach($explode_answer as $k => $v)
		{
			if(substr_count($quest,'{'.$k.'}'))
			{
				$question_ans_string = str_replace('{'.$k.'}','<b style="color:#234de7"><u>'.$v.'</u></b>',$question_ans_string);
				$question_ans[$k] = $question_ans_string.' ';
			}else{
				$question_ans[$k] = $question_ans_string.' ';
				
			}
		}
	}
	return end($question_ans);
}
function sort_question_answer_edit($question, $answer)
{
	$explode_question = explode(" ",$question);
	$explode_answer = explode(",",$answer);
	$question_ans = [];
	$question_ans_string = "";
	foreach($explode_question as $quest)
	{	
		$question_ans_string .= $quest." ";
		foreach($explode_answer as $k => $v)
		{
			if(substr_count($quest,'{'.$k.'}'))
			{
				$question_ans_string = str_replace('{'.$k.'}',' <input type="text" id="question"  style="width:100px" placeholder="titre de question" name="answer[]" value="'.$v.'" required> ',$question_ans_string);
				$question_ans[$k] = $question_ans_string.' ';
			}else{
				$question_ans[$k] = $question_ans_string.' ';
				
			}
		}
	}
	return end($question_ans);
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Section des enseignants</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="main.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
.error {
	color: red;
	margin-left: 5px;
}
label.error {
	display: inline;
}
.answer
{
	color:green;	
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="<?php echo '/'.FOLDER_PATH;?>">Portail Question Réponse</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active"> <a class="nav-link" href="<?php echo '/'.FOLDER_PATH;?>">Accueil <span class="sr-only">(current)</span></a> </li>
      
      <?php
      if(!empty($_SESSION['userJointTest'])){?>
       <li class="nav-item"> <a class="nav-link" href="<?php echo 'destory_user_session';?>">Se déconnecter</a> </li>
       <?php
       }?>
    </ul>
  </div>
</nav>
<div class="container"><br><br><br>
  <?php 
  if(empty($_SESSION['userJointTest'])){?>
	  
	  <form class="form-inline" method="POST" action="<?php echo 'write_user_session' ?>">
  <div class="col-lg-11">
    <div class="form-group">
     
      <input type="text" class="form-control" placeholder="Tapez votre nom" name="student_name" value=""/>
      
    </div> 
    </div>
    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
    
  </form>
  
  <?php
  }else{?>
	  <h1 class="text-center">Nom d'étudiant: <?php echo $_SESSION['userJointTest'];?></h1>
	  <hr>
  		<?php
        $p =1;
		foreach($questionAnswers as $questionAnswer){
	 		$checkStudentAnswer = getGivenAnswerByStudent($questionAnswer['id'],$_SESSION['userJointTest']);
			
	 		if($checkStudentAnswer == 0){?>
  
  <form class="form-inline" method="POST" action="<?php echo 'add_answer' ?>">
  <div class="col-lg-11">
    <div class="form-group">
     <?php 
	 echo 'Q-'.$p.'). '.sort_question_answer($questionAnswer['question'],$questionAnswer['answer'],$questionAnswer['answer_type']);
	 $p++;
	 
	 ?>
      
      
    </div> </div>
    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
    <input type="hidden" name="question_id" value="<?php echo $questionAnswer['id']?>"/>
  </form>
  
  
  <hr>
  <?php
	 }
  }
  
  }?>
  <h3 class="text-center"> votre question donnée.</h3>
  <br>
  <br>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">votre question et réponse</th>
      </tr>
    </thead>
    <tbody>
      <?php
	  $i = 1;
    foreach($studentQuestionAnswer as $questionAnswer){
		
		?>
        
      <tr>
        <th scope="row"><?php echo $i++?></th>
        
        
        <td colspan="2">
        <form class="form-inline" method="POST" action="<?php echo 'edit_answer' ?>">
        <span class="QuestionAnswerSection" style="display:block">
          <?php echo sort_question_answer_show($questionAnswer['question'],$questionAnswer['student_answer'])
		  ?>
          </span>
          <span  style="display:none">
          <?php echo sort_question_answer_edit($questionAnswer['question'],$questionAnswer['student_answer']);?>
          &nbsp;&nbsp;<i class="fa fa-times clickShowHide" aria-hidden="true"></i>
          
           &nbsp;&nbsp; &nbsp;&nbsp;<button type="submit"  class="btn btn-primary" name="submit" value="Éditer">Submit</button>
          <input type="hidden" name="questanswerId" value="<?php echo $questionAnswer['QuestionAnswerId']?>"/>
          <input type="hidden" name="questionId" value="<?php echo $questionAnswer['id']?>"/>
          </span>
         
          </form>
          </td>
          <td></td>
          
          
      </tr>
      <?php
	}?>
    </tbody>
  </table>
  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2021-2022 Portail Question Réponse</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">#</a></li>
      <li class="list-inline-item"><a href="#">#</a></li>
      <li class="list-inline-item"><a href="#">#</a></li>
    </ul>
  </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
	
	
	
	$('#formSubmission').submit(function(e) {
    
    var question = $('#question').val();
    var answer = $('#answer').val();
   
 	$(".error").remove()
	 if (question.length < 1) {
      $('#question').after('<span class="error">Ce champ est obligatoire.</span>');
    }
	else if ( question.indexOf("%%") == -1 ) {
		$('#question').after("<span class='error'>Vous devez mettre deux %% dans la question pour l'emplacement de la réponse</span>");
	}
	
     if (answer.length < 1) {
      $('#answer').after('<span class="error">Ce champ est obligatoire.</span>');
    }
	if(question.length != 0 && answer.length != 0){
		$('#formSubmission').submit();
	}
	return false;
    
  });


	
	
	
  
});

$('span.QuestionAnswerSection').dblclick(function(e) {
	$(this).css('display','none');
	$(this).next().css('display','block'); 
});

 $('.clickShowHide').click(function(e) {
    $(this).parent().hide();
	console.log($(this).parent().prev().before().show());
});
$('[data-toggle="tooltip"]').tooltip()

</script>
</body>
</html>