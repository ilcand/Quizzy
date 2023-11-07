<?php
//! business logic level

use function PHPSTORM_META\type;

class Controller extends Model{
  public function register($username, $email, $password, $role){
    $this->registerUser($username, $email, $password, $role);
  }

  public function currentUser($username){
    $currentUser = $this->getUser($username);
    return $currentUser;
  }

  public function getQuestion($id_user, $title, $type){
    $question = $this->getUserQuestion($id_user, $title, $type);
    return $question;
  }

  public function getQuestionAttr($id_question){
    $question = $this->getQuestionData($id_question);
    return $question;
  }

  public function answerID($title, $id_question){
    $id = $this->getAnswerID($title, $id_question);
    return $id;
  }

  //! used to format quiz selected questions before storing into DB
  public function getOptions($options){
    $list = '';
    foreach($options as $index => $option){
      if($index < (count($options) - 1)){
        $list = $list . $option . ',' . ' ';
      }else{
        $list = $list . $option;
      }
    }
    
    return $list;
  }

  public function getCorrect($id_question){
    $correct_answer = $this->getCorrectAnswers($id_question);
    return $correct_answer;
  }

  // format data by comma separated values
  public function formatData($data){
    $format = array();
    $dataSet = '';
    $dataSet = implode(", ", $data);

    for($index = 0; $index < count(explode(", ", $dataSet)); $index++){
      $data = explode(", ", $dataSet)[$index];
      $format[] = $data; 
    }

    return $format;
  }

  public function formatQuizzAnswers($answers, $question_type){
    $format = array();

    if(is_array($answers)){
      foreach($answers as $index => $answer){
        if($question_type === 'sa-text'){
          $format['sa-text'][$index] = $answer;
        }

        if($question_type === 'sa-mark'){
          $format['sa-mark'][$index] = $answer;
        }

        if($question_type === 'ma-checkbox'){
          $format['ma-checkbox'][$index] = $answer;
          //!! $format['id-question']['ma-chekbox'] = $id;
        }
    }
  }else if(!is_array($answers)){
    if($question_type === 'sa-text'){
      $format[0]['sa-text'] = $answers;
    }
   
    if($question_type === 'sa-mark'){
      $format[0]['sa-mark'] = $answers;
    }
  }

    return $format;
    
  }

  public function addQuestion($title, $type, $score, $owner){
    $this->insertQuestion($title, $type, $score, $owner);

  }

  public function questionID($title){
    $id = $this->getQuestionID($title);
    return $id;
  }

  //! used for quizzy functionality
  public function retrieveQuizzQuestionID($questions){
    $list = array();
    $questions = explode(', ', $questions);
    foreach($questions as $question){
      $id = $this->questionID($question);
      $list[] = $id[0];
    }

    return $list;
  }

  public function retrieveQuestionAnswers($id){
    $data = $this->getQuestionAnswers($id);
    return $data;
  }

  public function addAnswer($id_question, $title){
    $this->insertAnswer($id_question, $title);
  }

  public function addCorrectAnswer($id_question, $id_answer, $hidden){
    $this->insertCorrectAnswer($id_question, $id_answer, $hidden);
  }

  public function addAnswers($id_question, $correct_answer, $total_answers){
    $this->insertAnswers($id_question, $correct_answer, $total_answers);
  }

  public function questionCorrectAnswers($id_question){
    return $this->correctAnswers($id_question);
  }

  //* after submitting quizz data, assign points based on correct - answers
  public function evaluateQuestionAnswers($id_question, $answers){
    $score = 0;
    $question_attributes = $this->getQuestionAttr($id_question);
    $correct_answer = $this->getCorrect($id_question);

    if($question_attributes[0]['type'] === 'sa-text'){
      echo '<br>';
      echo 'Title: ' . $question_attributes[0]['title'] . '<br>';
      // echo 'SA-TEXT ' . '<br>';
      echo 'Correct Answer: '. $correct_answer[0] . '<br>';
      echo 'Score: ' . $question_attributes[0]['score']. '<br>';
      
      foreach($answers['sa-text'] as $index => $answer){
        if($answer === $correct_answer[0]){
          echo 'User Answer: ' . $answer . '<br>';
          $score = $score + (int)$question_attributes[0]['score'];
          echo 'Correct Answer: ';
          print_r($correct_answer[0]);
          echo '<br>';
        }
      }
     
      echo '<br>';
      echo 'SA-Text Array Data: ';
      print_r($answers['sa-text']);
      echo '<br>';
      
    }

    if($question_attributes[0]['type'] === 'sa-mark'){
      echo '<br>';
      echo 'Title: ' . $question_attributes[0]['title'] . '<br>';
      // echo 'SA-TEXT ' . '<br>';
      echo 'Correct Answer: '. $correct_answer[0] . '<br>';
      echo 'Score: ' . $question_attributes[0]['score']. '<br>';
      
      foreach($answers['sa-mark'] as $index => $answer){
        if($answer === $correct_answer[0]){
          echo 'User Answer: ' . $answer . '<br>';
          $score = $score + (int)$question_attributes[0]['score'];
          echo 'Correct Answer: ';
          print_r($correct_answer[0]);
          echo '<br>';
        }
      }

      echo '<br>';
      echo 'SA-MARK Array Data: ';
      print_r($answers['sa-mark']);
      echo '<br>';
  
    }

    if($question_attributes[0]['type'] === 'ma-checkbox'){
      $found_answers = 0;
      $correct_answers = explode(', ', $correct_answer[0]);
      echo '<br>';
      echo 'Title: ' . $question_attributes[0]['title'] . '<br>';
      // echo 'SA-TEXT ' . '<br>';
      echo 'Correct Answer: '. $correct_answer[0] . '<br>';
      echo 'CORRECT ANSWERS ARRAY: ';
      print_r($correct_answers);
      echo '<br>';
      echo 'Score: ' . $question_attributes[0]['score']. '<br>';
    
      foreach($answers['ma-checkbox'] as $index => $answer){
        echo 'User Answer: ' . '<br>';
        print_r($answer);
        echo '<br>';
        foreach($correct_answers as $index => $correct){
          if($answer === $correct){
            echo 'INDEX OF Checkbox ARRAY@#!@@!: ';
            print_r(array_search($answer, $answers['ma-checkbox']));
            echo '<br>';

            $element = array_search($answer, $answers['ma-checkbox']);
            // remove answer from list after evaluating
            // $displayError = unset($answers['ma-checkbox'][$element]);
            unset($answers['ma-checkbox'][$element]);
            $found_answers ++;
            echo 'ONE Correct Answer IDENTIFIED!: ';
            print_r($answer);
            echo '<br>';

            echo 'Number of Correct Answers: ';
            print_r(count($correct_answers));
            echo '<br>';
            if(count($correct_answers) === $found_answers){
              echo 'ADDING SCORE...' . '<br>';
              $score = $score + (int)$question_attributes[0]['score'];
            }
          }
        }
        
       
      }

      echo '<br>';
      echo 'MA-CHECKBOX Array Data: ';
      print_r($answers['ma-checkbox']);
      echo '<br>';

    }

    return $score;
   
  }

  public function addQuiz($title, $questions, $owner){
    $this->insertQuiz($title, $questions, $owner);
  } 

  //* used for updating question and answers
  public function questionConfig($id_question, $title, $score, $answers, $correct){
      $this->updateQuestion($id_question, $title, $score);
      
      $answers = $this->formatAnswers($answers);
      $correct = $this->formatAnswers($correct);

      $update = $this->updateAnswers($id_question, implode(', ', $answers), implode(', ', $correct));
      return $update;
    
  }

  public function deleteQuestion($id_question){
    $this->removeQuestion($id_question);
    $this->removeAnswers($id_question);
  }

  public function deleteUserQuestion($id_user, $id_question){
    $this->removeUserQuestion($id_user, $id_question);
  }

  public function quizConfig($title, $questions, $owner){
    $this->insertQuiz($title, $questions, $owner);
  }

  public function evaluateQuiz($id_quiz, $data){
    $max_score = 0;
    $score  = 0;
    $format = [];
    $memo = 0;

    //! format received data into associative array
    foreach($data as $index => $value){
      switch($value){
        case 'questionID':
          $format[$index]['question_id'] = $data[$index + 1]; 
          $memo = $index;
        break;
        
        case 'answer':
          $format[$memo]['answers'][$index] = $data[$index + 1];  
        break;
      }
    }
    
    //! verify sets within final array to assign points 
    foreach($format as $index => $set){
      $question = $this->getQuestionAttr($set['question_id']);
      $max_score += $question[0]['score'];

      $correct_answers = $this->questionCorrectAnswers($question[0]['id']);
      $counter = 0;
      
      
        switch($question[0]['type']){
          case 'ma-checkbox':
            $user_answers_counter = 0;

            foreach($correct_answers as $correct){
              foreach($set['answers'] as $index => $answer){
                // print_r(count($set['answers']));
                $user_answers_counter = count($set['answers']);
                // print_r("Contor curent: " . $user_answers_counter . ' ');
                $answer_id = $this->retrieveAnswerID($answer);
                if($correct['id_answer'] === $answer_id[0]['id']){
                  $counter ++;
                  // print_r("FOUND correct ANSWER");
                  // print_r("STEP counter: " . $counter . " ");
                  // print_r(" TOTAL CORRECT = " . count($correct_answers) . " ");
                  // print_r($correct_answers);
                }
              }
            }
            // print_r("Final counter = " . $counter . " ");
            // print_r("Final correct_answers_total = " . count($correct_answers) . " ");
            // print_r("Final_user_answers_total = " . $user_answers_counter . " ");

            if($counter !== count($correct_answers) || 
               $user_answers_counter !== count($correct_answers)){

                $counter = 0;
            }else{
              $score += $question[0]['score'];
            }
            
            $user_answers_counter = 0;
            print_r(" COUNTER MA-CHECKBOX = " . $counter);

          break;

          case 'sa-mark':
            foreach($set['answers'] as $index => $answer){
              $answer_id = $this->retrieveAnswerID($answer);
              if($correct_answers[0]['id_answer'] === $answer_id[0]['id']){
                $score += $question[0]['score'];
               
              }
            }

          break;
          
          case 'sa-text':
            foreach($set['answers'] as $index => $answer){
              $answer_id = $this->retrieveAnswerID($answer);
              if($correct_answers[0]['id_answer'] === $answer_id[0]['id']){
                $score += $question[0]['score'];
               
              }
            }

          break;
        }
    }

    // print_r("FINAL_SCORE ``` ~~~ ```: " . $score);
    $result = floatval($score / $max_score);
    
    return number_format($result, 2);

  }

  public function storeQuizResult($id_user, $id_quiz, $score){
    $this->insertUserQuizResult($id_user, $id_quiz, $score);
  }

}



?>