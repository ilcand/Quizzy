<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/homepage.css">
  <link rel="stylesheet" href="../css/mobileHomepage.css">
  <link rel="stylesheet" href="../css/mobileMenuHomepage.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Homepage</title>
</head>
<body>
  <nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/questions">Questions</a></li>
      <li><a href="http://localhost/Quizzy/app/quizzes">Quizzes</a></li>
      <li><a href="#">More <i class="fas fa-angle-down"></i></a> 
        <ul class="dropdown-items">
          <li><a href="http://localhost/Quizzy/app/question">Add Question</a></li>
          <li><a href="http://localhost/Quizzy/app/user/questions">My Questions </a></li>
          <li><a href="http://localhost/Quizzy/app/quiz">Create Quizz </li>
          <li><a href="http://localhost/Quizzy/app/user/quizzes">My Quizzes </a></li>
        </ul>
      </li>
    </ul>
    
  </nav>
  
  <div class="menu-wrap">
    <input type="checkbox" class="toggler">
    <div class="hamburger"> <div></div> </div>
    <div class="menu">
      <div>
        <div>
          <ul>
            <li><a href="http://localhost/Quizzy/app/questions">Questions</a></li>
            <li><a href="http://localhost/Quizzy/app/question">Add Question</a></li>
            <li><a href="http://localhost/Quizzy/app/user/questions">My Questions</a></li>
            <li><a href="http://localhost/Quizzy/app/quizzes">Quizzes</a></li>
            <li><a href="http://localhost/Quizzy/app/quiz">Create Quizz</a></li>
            <li><a href="http://localhost/Quizzy/app/user/quizzes">My Quizzes</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <section id="showcase">
    <div class="showcase-content">
      <div class="questions intro">
        <h1>Questions</h1>
        <div class="container-options">
         <a class="btn-option" href="http://localhost/Quizzy/app/questions"> <button class="btn"><span class="option-text">Questions Available</span></button></a>
         <a class="btn-option" href="http://localhost/Quizzy/app/question"><button class="btn"><span class="option-text">Add Question</span></button></a>
         <a class="btn-option" href="http://localhost/Quizzy/app/user/questions"><button class="btn"><span class="option-text">My Questions</span></button></a>
        </div>
      </div>

      <div class="quizzes intro">
        <h1>Quizzes</h1>
        <div class="container-options">
          <a class="btn-option" href="http://localhost/Quizzy/app/quizzes"><button class="btn"><span class="option-text">Quizzes Available</span></button></a>
          <a class="btn-option" href="http://localhost/Quizzy/app/quiz"><button class="btn"><span class="option-text">Create Quizz</span></button></a>
          <a class="btn-option" href="http://localhost/Quizzy/app/user/quizzes"><button class="btn"><span class="option-text">My Quizzes</span></button></a>
        </div>
      </div>
      
    </div>
  </section>
</body>
</html>