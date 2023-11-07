<?php 
//! only the model interacts with database

class Model extends DB{
  
  protected function registerUser($username, $email, $password, $role){
    $sql = "INSERT INTO users(username, password, email, role) VALUES(:username, :password, :email, :role)";
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':role', $role);
    $statement->execute();
  }

  // !rebuild this function to check for user id too (improves accuracy)
  protected function getUser($username){
    $sql = "SELECT * FROM users WHERE username = :username";
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->execute();

    $currentUser = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $currentUser;
  }

  protected function getUsers(){
    $sql = "SELECT users.id, users.username FROM users";
    $statement = $this->connect()->prepare($sql);
    $statement->execute();

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }

  protected function getUserQuestion($id_user, $title, $type){
    // where owner = id_user
    $sql = 'SELECT questions.* FROM questions 
            INNER JOIN users ON questions.owner = :id_user
            WHERE questions.title = :title AND questions.type = :type';
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_user', $id_user);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':type', $type);
    $statement->execute();

    $question = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $question;
  }

  protected function getQuestions(){
    $sql = "SELECT questions.* FROM questions";
    $statement = $this->connect()->prepare($sql);
    $statement->execute();

    $questions = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $questions;
  }

  protected function getQuestionData($id_question){
    $sql = "SELECT questions.* FROM questions
            WHERE questions.id = :id_question";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', $id_question);
    $statement->execute();

    $question = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $question;
  }

  protected function getQuestionID($title){
    $sql = "SELECT questions.id FROM questions
            WHERE questions.title = :title";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':title', (string)$title);
    $statement->execute();

    $questionID = $statement->fetchAll(PDO::FETCH_COLUMN);
 
    return $questionID;
  }

  protected function retrieveAnswerID($title){
    $sql = "SELECT DISTINCT answers.id FROM answers 
            WHERE answers.title = :title";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':title', (string)$title);
    $statement->execute();

    $id = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $id;
  }

  protected function getAnswerID($title, $id_question){
    $sql = "SELECT answers.id FROM answers 
            INNER JOIN questions ON answers.id_question = :id_question
            WHERE answers.title = :title";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', (int)$id_question);
    $statement->bindValue(':title', (string)$title);
    $statement->execute();

    $answer = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $answer;
  }

  protected function getQuestionAnswers($id_question){
    $sql = "SELECT answers.* FROM answers 
            INNER JOIN questions ON answers.id_question = questions.id
            WHERE questions.id = :id_question";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', (int)$id_question);
    $statement->execute();

    $answers = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $answers;
  }

  // retrieve correct answers associated to question
  protected function correctAnswers($id_question){
    $sql = "SELECT DISTINCT correct.*, answers.title FROM answers
            JOIN questions ON answers.id_question = :id_question
            INNER JOIN correct ON correct.id_answer = answers.id";
            
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', $id_question);
    $statement->execute();

    $correct = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $correct;
  }


  protected function getCorrectAnswers($id_question){
    $sql = "SELECT answers.* FROM answers
            INNER JOIN questions ON answers.id_question = questions.id
            WHERE answers.id_question = :id_question";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', (int)$id_question);
    $statement->execute();

    $correct = $statement->fetchAll(PDO::FETCH_COLUMN);

    return $correct;
  }

  protected function getUserQuestions($id_user){
    $sql = "SELECT questions.* FROM questions
            INNER JOIN users ON questions.owner = users.id
            WHERE users.id = :id_user";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_user', $id_user);
    $statement->execute();

    $userQuestions = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $userQuestions;
  }

  protected function getQuizzes(){
    $sql = "SELECT quizzes.*, users.username FROM quizzes
            INNER JOIN users ON quizzes.owner = users.id";

    $statement = $this->connect()->prepare($sql);
    $statement->execute();

    $quizzes = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $quizzes;
  }

  protected function getUserQuizzes($id_user){
    $sql = "SELECT quizzes.* FROM quizzes
            WHERE quizzes.owner = :owner";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':owner', $id_user);
    $statement->execute();

    $quizzes = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $quizzes;
  }

  protected function retrieveUserQuizzyResults($id_user){
    $sql = "SELECT results.*, quizzes.* FROM results
            INNER JOIN quizzes ON results.quiz_id = quizzes.id 
            WHERE user_id = :id_user";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_user', $id_user);
    $statement->execute();

    return;
  }

  protected function insertUserQuizResult($id_user, $id_quiz, $score){
    $sql = "INSERT INTO results(user_id, quiz_id, score) 
            VALUES(:id_user, :id_quiz, :score)";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_user', (int)$id_user);
    $statement->bindValue(':id_quiz', (int)$id_quiz);
    $statement->bindValue(':score', (float)$score);
    $statement->execute();

    return;
  }

  protected function getQuizzData($id_quizz){
    $sql = "SELECT quizzes.* FROM quizzes
            WHERE quizzes.id = :id_quizz";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_quizz', $id_quizz);
    $statement->execute();

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }

  // question type: correct answer
  protected function insertQuestion($title, $type, $score, $owner){
    $sql = 'INSERT INTO questions(title, type, score, owner) 
            VALUES(:title, :type, :score, :owner)';
            
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':title', (string)$title);
    $statement->bindValue(':type', (string)$type);
    $statement->bindValue(':score', (float)$score);
    $statement->bindValue(':owner', (int)$owner);
    $statement->execute();

    return;
  }

  protected function insertAnswer($id_question, $title){
    $sql = "INSERT INTO answers(id_question, title) 
            VALUES(:id_question, :title)";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', $id_question);
    $statement->bindValue(':title', $title);
    $statement->execute();

  return;

  }

  // hidden represents a boolean value, guidance for view-format
  protected function insertCorrectAnswer($id_question, $id_answer, $hidden){
    $sql = "INSERT INTO correct(id_question, id_answer, hidden)
            VALUES(:id_question, :id_answer, :hidden)";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', (int)$id_question);
    $statement->bindValue(':id_answer', (int)$id_answer);
    $statement->bindValue(':hidden', (int)$hidden);
    $statement->execute();

    return;
  }
  
  protected function insertAnswers($id_question, $correct_answer, $total_answers){
    $sql = "INSERT INTO answers(id_question, correct_answer, total_answers) 
            VALUES(:id_question, :correct_answer, :total_answers)";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', $id_question);
    $statement->bindValue(':correct_answer', $correct_answer);
    $statement->bindValue(':total_answers', $total_answers);
    $statement->execute();

    return;
  }

  protected function insertQuiz($title, $questions, $owner){
    $sql = "INSERT INTO quizzes(title, questions, owner)
            VALUES(:title, :questions, :owner)";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':questions', $questions);
    $statement->bindValue(':owner', $owner);
    $statement->execute();

    return;

  }

  // modify question
  protected function updateQuestion($id_question, $title, $score){
    $sql = "UPDATE questions
            SET questions.title = :title, questions.score = :score
            WHERE questions.id = :id";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id', $id_question);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':score', $score);
    $statement->execute();
           
    return;
  }

  
  
  // !view-> format answers first
  protected function updateAnswers($id_question, $answers, $correct){
    $sql = "UPDATE answers
            INNER JOIN questions ON answers.id_question = questions.id
            SET answers.total_answers = :answers, answers.correct_answer = :correct            
            WHERE answers.id_question = :id_question";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', (int)$id_question);
    $statement->bindValue(':answers', $answers);
    $statement->bindValue(':correct', $correct);
    $statement->execute();

    return;
  }

  protected function updateQuizz($title, $questions, $owner){
    $sql = "UPDATE quizzes
            SET quizzes.title = :title, quizzes.questions = :questions
            WHERE quizzes.owner = :owner";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':questions', $questions);
    $statement->bindValue(':owner', $owner);
    $statement->execute();

    return;
  }

  protected function removeQuestion($id_question){
    $sql = "DELETE questions.* FROM questions
            WHERE questions.id = :id_question";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', (int)$id_question);
    $statement->execute();

    return;
  }

  protected function removeAnswers($id_question){
    $sql = "DELETE answers.* FROM answers
            WHERE answers.id_question = :id_question";
    
    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(':id_question', $id_question);
    $statement->execute();

    return;
  }

  protected function removeUserQuestion($id_user, $id_question){
    $sql = "DELETE questions.* FROM questions WHERE
            questions.owner = :id_user AND questions.id = :id_question";

    $statement = $this->connect()->prepare($sql);
    $statement->bindValue(":id_user", $id_user);
    $statement->bindValue(":id_question", $id_question);
    $statement->execute();

    return;

  }

}


?>