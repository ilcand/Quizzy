<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/quiz.css">
  <link rel="stylesheet" href="../css/mobileQuiz.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="../js/quiz_interactions.js" defer></script>
  <title>Add Quiz</title>
</head>
<body>
  <nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Quizz</a></li>
      <li><a href="http://localhost/Quizzy/app/home">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/quizzes">Quizzes</a></li>
      <li><a href="#">More <i class="fas fa-angle-down"></i></a> 
        <ul class="dropdown-items">
          <li><a href="http://localhost/Quizzy/app/question">Add Question</a></li>
          <li><a href="http://localhost/Quizzy/app/user/questions">My Questions</a></li>
          <li><a href="http://localhost/Quizzy/app/quiz">Create Quiz</a></li>
          <li><a href="http://localhost/Quizzy/app/user/quizzes">My Quizzes</a></li>
        </ul>
      </li>
    </ul>
    
  </nav>

  <div id="showcase">
    <div class="showcase-overlay"></div>
    <div class="showcase-content">
      <div class="container-form">
        <form action="http://localhost/Quizzy/app/quizzes" method="POST">
          <div class="form-group">
            <h1>Quiz Title</h1>
            <input name="title" type="text" required autocomplete="off">
          </div>

          <div class="form-group">
            <h1>Add Questions</h1>
            <div class="questions">
              <!-- <input type="text" required autocomplete="off"> -->
            </div>

            <div class="interactions">
              <ul class="dropdown-question_type">
                <li class = "myQuestions">My Questions</li>
                <li class = "totalQuestions">Questions</li>
              </ul>
            </div>

            <i id="add-questions" class="fas fa-plus-square"></i>
            
          </div>
          

          <div class="form-group">
            <button class="btn-save">Save</button>
          </div>

          <div class="form-group">
            <input type="submit" class="btn-submit">
          </div>
        </form>
      </div>
    </div>
</body>
</html>