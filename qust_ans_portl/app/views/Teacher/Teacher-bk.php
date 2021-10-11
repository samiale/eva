<?php defined('BASEPATH') or exit('No se permite acceso directo'); 


function sort_question_answer($question, $answer)
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
				$question_ans_string = str_replace('{'.$k.'}','<span class="answer"><u>'.strtoupper($v).'</u></span>',$question_ans_string);
				$question_ans[$k] = $question_ans_string.' ';
			}
			else{
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
      <li class="nav-item active"> <a class="nav-link" href="<?php echo 'index';?>">Accueil <span class="sr-only">(current)</span></a> </li>
      <li class="nav-item"> <a class="nav-link" href="<?php echo '/'.FOLDER_PATH;?>">étudiant</a> </li>
    </ul>
  </div>
</nav>
<div class="container">
  <div class="py-5 text-center"> <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h2>Ajouter un formulaire de question.</h2>
  </div>
  <h3 class="text-center"> Formulaire de questions.</h3>
  <form id="formSubmission" method="POST" action="<?php echo 'add_question' ?>">
    <div class="form-group">
      <label for="validationTextarea">titre de question</label>
      <textarea class="form-control" id="question" name="question" placeholder="titre de question" >%%</textarea>
      <div  style="color:red">Remarque : (En mettant deux signes pour cent %% entre la réponse à la question, le système la considérera automatiquement comme une réponse. Au moins une paire de signes % entre la réponse autant de réponses que vous souhaitez ajouter , vous pouvez utiliser deux signes % pour la réponse. <br>
        par exemple, où %habitez-vous% ?</div>
    </div>
    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
  </form>
  <hr>
  <h3 class="text-center"> Liste de questions.</h3>
  <br>
  <br>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Question</th>
      </tr>
    </thead>
    <tbody>
      <?php
	  $i = 1;
    foreach($questionAnswers as $questionAnswer){?>
      <tr>
        <th scope="row"><?php echo $i++?></th>
        <td>
        <span class="QuestionAnswerSection" style="display:block">
          <?php echo preg_replace("/{(.*?)}/","______",$questionAnswer['question']);?>
          </span>
          <span  style="display:none">
          <?php echo sort_question_answer($questionAnswer['question'],$questionAnswer['answer']);?>
          &nbsp;&nbsp;<i class="fa fa-times clickShowHide" aria-hidden="true"></i></span>
          
          </td>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
	
	$("#question").change(function(e) {
		
		var question = $('#question').val();
		
		console.log(countSpecial(question));
		
		
		strg = 'my name is ayaz ishaq thanks %% who are you %% my name is ayaz %% ended.'
	strings = strg.split(' ');
	arrays = ['test','joke','speach'];
	newStr = '';
	newStr1 = '';
	existingArray = [];
	for(l=0;l<strings.length;l++)
	{
		
		if(strings[l] == '%%')
		{
			for(h=0; h<arrays.length;h++){
				if(!existingArray.includes(h))
				{
					newStr1 = '%'+arrays[h]+'% ';
					existingArray.push(h);
					break;
				}	
			}
		}
		else
		{
			newStr1 = strings[l]+' ';
		}
		newStr +=newStr1;
	}
	console.log(newStr);
        
return false;
    });
	
	
	
	$('#formSubmission').submit(function(e) {
		
return false;
    
    
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
function countSpecial(string) {
   var punct = "%";
   var count = 0;
   for(var i = 0; i < string.length; i++){
      if(!punct.includes(string[i])){
         continue;
      };
      count++;
   };
   
   if(count % 2 === 0)
   {
		return (count/2);
   }
   else if(count % 2 !== 0){
	  return ((count - 1) / 2);
   }
  
   };
</script>
</body>
</html>