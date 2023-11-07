<?php 
//! user data display format
class View extends Model{
  public function displayQuestions(){
    $questions = $this->getQuestions();
    return $questions;
  }

  public function displayUserQuestions($id_user){
    $userQuestions = $this->getUserQuestions($id_user);
    return $userQuestions;
  }

  public function displayAnswers($id_question){
    $answers = $this->getAnswers($id_question);
    return $answers;
  }

  public function displayQuizzes(){
    $quizzes = $this->getQuizzes();
    return $quizzes;
  }

  public function displayQuizzData($id_quizz){
    $data = $this->getQuizzData($id_quizz);
    return $data;
  }

  public function displayUsers(){
    $users = $this->getUsers();
    return $users;
  }

  public function displayUserQuizzyResults($id_user){
    $results = $this->retrieveUserQuizzyResults($id_user);
    return $results;
  }

}



?>