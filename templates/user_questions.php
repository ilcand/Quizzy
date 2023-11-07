<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/user_questions.css">
  <link rel="stylesheet" href="../../css/mobileUserQuestions.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>My Questions</title>
</head>
<body>
<!-- TODO: display list of questions asked by an user 
            -> question->answers/question->right answer !OPT -> score
        !OPT-> user can edit question score, answers/text 
            -> user can delete question -> question must get removed from quizz too
  -->

  <nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">My Questions</a></li>
      <li><a href="http://localhost/Quizzy/app/home">Home</a></li>
      <li><a href="http://localhost/Quizzy/app/quizzes">Quizzes</a></li>
      <li><a href="#">More <i class="fas fa-angle-down"></i></a> 
        <ul class="dropdown-items">
          <li><a href="http://localhost/Quizzy/app/question">Add Question</a></li>
          <li><a href="http://localhost/Quizzy/app/questions">Questions</a></li>
          <li><a href="http://localhost/Quizzy/app/quizz">Create Quizz</a></li>
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
            <th>Question</th>
            <th>Score </th>
            <th>Answers</th>
            <th></th>
           
          </tr>
  
        {% for question in questions %}
          <tr>
            <td>{{ question.title }}</td>
            <td>{{ question.score }}</td>
            <td>
              <form action="http://localhost/Quizzy/answers" method="POST">
                <input class="hidden" type="number" name="id_question" value="{{ question.id }}">
                <input class="hidden" type="text" name="question_title" value="{{ question.title }}">
                <button type="submit" class="btn">Check</button>
              </form>
            </td>
            <td>
              <form action="http://localhost/Quizzy/user/question/config" method="POST">
                <input class="hidden" type="number" name="id_question" value="{{ question.id }}">
                <button type="submit" class="btn">Edit</button>
              </form>
            </td>
          </tr>
            {% endfor %}

            {% if questions is empty %}
              <tr>
                <td><b> No Questions To Show </b></td>
                <td> </td>
                <td> </td>
                <td><a  href="http://localhost/Quizzy/app/question" class="btn">Add Questions</a></td>
              </tr>
            {% endif %}
          
  
          <!-- <tr>
            <td>2</td>
            <td>Lorem ipsum dolor sit amet consectetur?</td>
            <td>
              Answer 1 <br>
              Answer 2 <br>
              Answer 3 <br>
              Answer 4 <br>
              Answer 5 <br>
            </td>
            <td>score</td>
            <td><button class="btn">Edit</button></td>
          </tr> -->
  
          
        </table>
    </div>
    </div>
  </div>
</body>
</html>