<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/quizzy.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="../../js/quizzy.js" defer></script>
  <title>Quizzy</title>
</head>
<body>
<nav id="navbar">
    <ul class="navbar-items">
      <li class="active"><a href="#">Quizzy</a></li>
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

  <div id="showcase">
    <div class="showcase-overlay"></div>
    <div class="showcase-content">
      <div class="container-form">
      
        <form id="quiz">
            <div class="form-group">
              <h1><b> {{ quiz_data.title }} </b></h1>
              <input id="quizID" type="hidden" value="{{ quiz_data.id }}">
            </div>
            {% for key, question in questions %}
              <div class="form-group question">
                <h1 class="question-title">{{ question.title }}</h1>
                {% if question.type == "sa-text" %}
                  <input type="text" class="sa-text answer" name="sa-text[]" autocomplete="off" required>
                {% endif %}
                
                {% if question.type == "sa-mark" %}
                  {% for answer in answers %}
                    {% for a in answer %}
                      {% if question.id == a.id_question %}
                        <li class="sa-mark answer">{{ a.title }}</li>
                      {% endif %}
                      
                    {% endfor %}
                  {% endfor %}
                {% endif %}
            
                
                {% if question.type == "ma-checkbox" %}
                  {% for answer in answers %}
                    {% for a in answer %}
                      {% if question.id == a.id_question %}
                        <li class="ma-checkbox answer">{{ a.title }}</li>
                      {% endif %}
                      {% endfor %}
                  {% endfor %}
                {% endif %}

                <input type="hidden" class="question_id" name="question_id[]" value="{{ question.id }}">
                <input type="hidden" class="question_type" name="question_type[]" value="{{ question.type }}">
                
                <div class="answers">

                </div>
              </div>
            {% endfor %}
          

          <div id="user_answers" class="form-group anwers">

          </div>

          <div class="form-group container-submit">
            <button id="save-btn" class="btn"> Save </button>
            <input style="display:none;" type="submit" class="btn" id="sub">
          </div>
        </form>
      </div>
    </div>
</body>
</html>