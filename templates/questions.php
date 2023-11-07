<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/questions.css">
  <link rel="stylesheet" href="../css/mobileQuestions.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Questions</title>
</head>
<body>
  <!-- TODO: display list of questions with a reference to the available answers for a selected question -->
  
  <nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Questions</a></li>
      <li><a href="http://localhost/Quizzy/app/home">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/quizzes">Quizzes</a></li>
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
    <!-- <h1 style="color: #fff; display: block;">Questions</h1> -->
    <div class="container-table">
      <table>
        
        <tr>
          <th>Nr. CRT</th>
          <th>Question </th>
          <th>Asked By </th>
          <th>Score </th>
          <th>Answers </th>
        </tr>

        {% set index = 0 %}

        {% for question in questions %}
        {% set index = index + 1 %}
        <tr>
          <td>{{ index }}</td>
          <td>{{ question.title }}</td>
          <td>{{ question.owner }} </td>
          <td>{{ question.score }}</td>
          <td><button class="btn">Check</button></td>
        </tr>
        {% endfor %}

        {% if questions is empty %}
        <tr>
          <td>No Questions To Show</td>
          <td><button class="btn">Add Questions</button></td>
        </tr>
        {% endif %}
      </table>
  </div>
  </div>
</div>
</body>
</html>