<?php 
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/question.css">
  <link rel="stylesheet" href="../css/mobileQuestion.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="../js/question_interactions.js" defer></script>
  <title>Add Questions</title>
</head>
<body>
    <!-- TODO: user creates question -> text_question
                                   -> add possible answers
                                   -> select which of the added answers is correct
                               !OPT-> set score / set it when creating a quizz -->
<nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Question</a></li>
      <li><a href="http://localhost/Quizzy/app/home">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/quizzes">Quizzes</a></li>
      <li><a href="#">More <i class="fas fa-angle-down"></i></a> 
        <ul class="dropdown-items">
          <li><a href="#">Add Question</a></li>
          <li><a href="http://localhost/Quizzy/app/user/questions">My Questions</a></li>
          <li><a href="http://localhost/Quizzy/app/quiz">Create Quizz</a></li>
          <li><a href="http://localhost/Quizzy/app/user/quizzes">My Quizzes</a></li>
        </ul>
      </li>
    </ul>
    
  </nav>

  <div id="showcase">
    <div class="showcase-overlay"></div>
    <div class="showcase-content">
      <div class="container-form">
        <form action="http://localhost/Quizzy/app/question" method="POST">
          <div class="form-group">
            <h1>Question Title</h1>
            <input type="text" name="question_title" required autocomplete="off">
          </div>

          <div class="form-group container-answers">
            <h1 class="header-add_answers">Add Answers</h1>
            <div class="answers">
              <!-- <input type="text" required autocomplete="off"> -->
            </div>
            <div id="interactions">
              <ul class="dropdown-question_type">
                <!-- <li>Select Answer Type</li> -->
                <li class="answer_text">Single Answer - Text</li>
                  
                <li class="answer_mark">Single Answer - Mark From List</li>
                  
                <li class="answer_multiple">Multiple Answers</li>
               
                
              </ul>
            </div>
              <i id="interactions-btn" class="fas fa-plus-square"></i>
              
            
          </div>

          <div class="form-group">
            <h1 id="correct-header">Correct Answer 
                
          </h1>
            <!-- <input type="text" required autocomplete="off"> -->
            <div class="list-correct form-group">
              <!-- TODO: generate list of correct possible answers -->
            </div>
            <i id="correct-btn" class="fas fa-plus-square"></i>
          </div>

          <div class="form-group container-score">
            <h1>Score (0 - 10)</h1>
            <input type="number" name="score" class="score">
          </div>

          <div class="form-group container-submit">
            <input type="submit" class="btn">
          </div>
        </form>
      </div>
    </div>
</body>
</html>