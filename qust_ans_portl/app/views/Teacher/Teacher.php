<?php defined('BASEPATH') or exit('No se permite acceso directo'); 


function sort_question_answer($question, $answer,$answer_type)
{
	$explode_question = explode(" ",$question);
	$explode_answer = explode(",",$answer);
	$explode_answer_type = explode(",",$answer_type);
	$question_ans = [];
	$question_ans_string = "";
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
				
				$question_ans_string = str_replace('{'.$k.'}','<span class="answer"><u data-toggle="tooltip" data-placement="top" title="'.$answerTypelable.'">'.strtoupper($v).'</u></span>',$question_ans_string);
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
.answer {
	color: green;
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
  <div class="py-5 text-center"> 
    <h2>Ajouter un formulaire de question.</h2>
  </div>
  <h3 class="text-center"> Formulaire de questions.</h3>
  <form id="formSubmission" method="POST" action="<?php echo 'add_question' ?>">
    <div class="form-group">
      <label for="validationTextarea">titre de question</label>
      <textarea class="form-control" id="question" name="question" placeholder="titre de question" ></textarea>
      <div  style="color:red">Remarque : (dans la question où vous voulez mettre la réponse, écrivez simplement deux signes de pourcentage %%, puis le système considérera sa section de réponse une fois que votre question sera complétée ci-dessous le champ de réponse sera généré automatiquement sur deux pourcentages %% Veuillez toujours mettre un espace à côté signe %% sinon il ne sera pas compté dans la réponse).</div>
    </div>
    <div id="answerTypeSection">
      <div class="form-group row answerTypebox"></div>
      <div class="form-group row answerBox"></div>
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
        <td><span class="QuestionAnswerSection" style="display:block"> <?php echo preg_replace("/{(.*?)}/","______",$questionAnswer['question']);?> </span> <span  style="display:none"> <?php echo sort_question_answer($questionAnswer['question'],$questionAnswer['answer'],$questionAnswer['answer_type']);?> &nbsp;&nbsp;<i class="fa fa-times clickShowHide" aria-hidden="true"></i></span></td>
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
	
	$("#question").change(function(e) {
		var question = $(this).val();
		totalAnswerBox = countSpecial(question)
		if(totalAnswerBox>0)
		{
			for(v=0;v<totalAnswerBox;v++){	
			$('div#answerTypeSection').children('div.answerBox').append('<div class="col-xs-1"><input style="width:140px" placeholder="Réponse" class="form-control" type="text" name="answer[]"></div>');
			$('div#answerTypeSection').children('div.answerTypebox').append('<div class="col-xs-1"><select style="width:140px" class="form-control" title="Sélectionnez le type de réponse"  name="answerType[]"><option value="">Sélectionnez le type de réponse</option><option value="1">Expression</option><option value="2">Mot</option></select></div>');
			}
		}
		$(this).attr('readonly',true);
		return false;
    });
	$('#formSubmission').submit(function(e) {
    var answer = $('#answer').val();
   var question = $('#question').val();
 	$(".error").remove()
	 if (question.length < 1) {
      $('#question').after('<span class="error">Ce champ est obligatoire.</span>');
	  return false
    }
	else if ( question.indexOf("%%") == -1 ) {
		$('#question').after("<span class='error'>Vous devez mettre deux %% dans la question pour l'emplacement de la réponse</span>");
		return false
	}
	$formFieldType = $('div#answerTypeSection').children('div.answerTypebox').find('select[name="answerType[]"]');;
	$formFieldAnswer = $('div#answerTypeSection').children('div.answerBox').find('input[name="answer[]"]');;
	error = false;
	$.each($formFieldType,function(index,value){
		if($(value).val() == '') {
			$(value).after('<span class="error">Ce champ est requis.</span>');
			error = true;
		}
			
		})
		$.each($formFieldAnswer,function(index,value){
		if($(value).val() == '') {
			$(value).after('<span class="error">Ce champ est requis.</span>');
			error = true;
		}
		})
		if(error == true){
			return false;
		}
	var answerArray = [];
	$.each($(this).serializeArray(),function(index,value)
	{
		if(value.name == 'answer[]')
		{
			answerArray.push(value.value);
		}
	});		
	newStr = '';
	newStr1 = '';
	existingArray = [];
	question = question.split(' ');
	for(l=0;l<question.length;l++)
	{
		if(question[l] == '%%')
		{
			for(h=0; h<answerArray.length;h++){
				if(!existingArray.includes(h))
				{
					newStr1 = '%'+answerArray[h]+'% ';
					existingArray.push(h);
					break;
				}	
			}
		}
		else
		{
			newStr1 = question[l]+' ';
		}
		newStr +=newStr1;
	}
	$.ajax({type:'POST',
			data:{data:$(this).serialize(),parsequestion:newStr,'submit':'Submit'},
			url:$(this).attr('action'),
			dataType:"JSON",
			success: function(data)
			{
				if(data.action == true){
					
				window.location="index"	;
				}
				else{
					alert('error');	
				}
			}
		});	
		return false
});


$('span.QuestionAnswerSection').dblclick(function(e) {
	$(this).css('display','none');
	$(this).next().css('display','block'); 
});


 $('.clickShowHide').click(function(e) {
    $(this).parent().hide();
	$(this).parent().prev().before().show();
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
   return 0;
  
   }
});
$('[data-toggle="tooltip"]').tooltip()
</script>
</body>
</html>