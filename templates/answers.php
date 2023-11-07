<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/answers.css">
  <link rel="stylesheet" href="../css/mobileAnswers.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Answers</title>
</head>
<body>
  <!-- TODO: display available answers for a question selected previously -->
  <nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Answers</a></li>
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
    <div class="container-table">
      <table>
        <tr>
          
          <th>Question </th>
          <th>Answers </th>
          
        </tr>

        <tr>
          
          <td>Title</td>

          <td>
           
            Answer1 <br>
            Answer2 <br>
            Answer3 <br>
        
          </td>
          
        </tr>

       
      </table>
  </div>
  </div>
</div>  
 
</body>
</html>