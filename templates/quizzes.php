<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/quizzes.css">
  <link rel="stylesheet" href="../css/mobileQuizzes.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Quizzes</title>
</head>
<body>
  <!-- TODO: display list of questions with a reference to the available answers for a selected question -->
  
  <nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Quizzes</a></li>
      <li><a href="http://localhost/Quizzy/app/home">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/questions">Questions</a></li>
      <li><a href="#">More <i class="fas fa-angle-down"></i></a> 
        <ul class="dropdown-items">
          <li><a href="http://localhost/Quizzy/app/question">Add Question</a></li>
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
    <div class="container-table">
      <table>
        
        <tr>
          <th>Nr. CRT</th>
          <th>Quiz </th>
          <th>Created By </th>
          <th></th>
        </tr>

        {% set index = 0 %}

        {% for quiz in quizzes %}
        {% set index = index + 1 %}
        <tr>
          <td>{{ index }}</td>
          <td>{{ quiz.title }}</td>
          <td>{{ quiz.username }} </td>
          <td><a href="http://localhost/Quizzy/app/quizzes/{{ quiz.id }}" class="btn"><b>Start</b></a></td>
        </tr>
        {% endfor %}

        {% if quizzes is empty %}
        <tr>
          <td>No Quizzes To Show</td>
          <td><a href="http://localhost/Quizzy/app/quiz" class="btn">Add Quiz</a></td>
        </tr>
        {% endif %}
      </table>
  </div>
  </div>
</div>
</body>
</html>