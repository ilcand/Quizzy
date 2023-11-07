<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

$config = '/config/config.php';
$mvcLoader = '/Loader/load.php';
require_once('../vendor/autoload.php');
require_once(dirname(__DIR__) . $config);
require_once(dirname(__DIR__) . $mvcLoader);

// twig loader
$loader = new \Twig\Loader\FilesystemLoader([$templateDir]);
// $twig = new Twig\Environment($loader, $cacheDir);
$twig = new \Twig\Environment($loader);

$controller = new Controller();
$view = new View();

/**
 * @OA\Info(title="Quizzy", version="1.0")
 */

 /**
 * @OA\Server(url="http://localhost/Quizzy/app/docs")
 */

$app = AppFactory::create();
$app->setBasePath("/Quizzy/app");

$app->get('/', function($request, $response) use($twig){
  echo $twig->render('login.php');
  return $response;
});

$app->get('/register', function($request, $response) use($twig){
  echo $twig->render('register.php');
  return $response;
});

$app->post('/register', function($request, $response) use($controller){
  if(isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password-confirm']) &&
  $_POST['password'] === $_POST['password-confirm']){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $securePassword = md5($password);
    $email = $_POST['email'];
    $role = 'user';
    $controller->register($username, $email, $securePassword, $role);
    $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app')->withStatus(301);
    return $newResponse;
  } 
  
  return $response;
});

// login user
$app->post('/auth', function($request, $response) use($controller){
  if(isset($_POST['username'], $_POST['password'], $_POST['password-confirm']) &&
    $_POST['password'] === $_POST['password-confirm']){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $currentUser = $controller->currentUser($username);
    if(!$currentUser){
      $response->getBody()->write("401 - Wrong Credentials"); 
      return $response;
    }
    $securePassword = $currentUser[0]['password'];

    if(md5($password) === $securePassword){
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $currentUser[0]['id'];

      //! withStatus(301) -> makes sure browser redirects user to location, some browsers require it
      $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app/home')->withStatus(301);
      
      return $newResponse;
    }
  } 

  $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app')->withStatus(301);
  return $newResponse;
});

$app->get('/home', function($request, $response) use($twig){
  session_start();
  if(isset($_SESSION['username'], $_SESSION['user_id'])){
    echo $twig->render('homepage.php');
    return $response;

  }else{
    $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app')->withStatus(301);
    return $newResponse;
  }
  return $response;
});

//! user

$app->get('/user/questions', function($request, $response) use($twig, $view){
  session_start();
  $id_user = $_SESSION['user_id'];
  $questions = $view->displayUserQuestions($id_user);
  
  echo $twig->render('user_questions.php', array(
    'questions' => $questions,
    
  ));

  
  return $response;
});

$app->get('/user/quizzes', function($request, $response) use($twig){
  $quizzes = '';
  $users = '';
  echo $twig->render('user_quizzes.php', array(
    'quizzes' => $quizzes,
    'users' => $users
    
  ));
  return $response;
});

$app->get('/user/results', function($request, $response) use($twig, $view){
  $results = '';
  $quizzes = '';

  echo $twig->render('user_quizzes.php', array(
    'results' => $results,
    'quizzes' => $quizzes
  ));
  
  return $response;
});

$app->get('/question', function($request, $response) use($twig){
  echo $twig->render('question.php');
  return $response;
});

$app->get('/questions', function($request, $response) use($twig, $view){
  $questions = $view->displayQuestions();
  echo $twig->render('questions.php', array(
    'questions' => $questions
    
  ));
  return $response;
});

$app->get('/answers', function($request, $response) use($twig){
  echo $twig->render('answers.php');
  return $response;
});

$app->get('/quiz', function($request, $response) use($twig){
  echo $twig->render('quiz.php');
  return $response;
});

$app->get('/quizzes', function($request, $response) use($twig, $view){
  $quizzes = $view->displayQuizzes();

  echo $twig->render('quizzes.php', array(
      'quizzes' => $quizzes 
  ));

  return $response;
});

//! quizz data - answers - questions
$app->get('/quizzes/{id}', function($request, $response, $args) use($twig, $view, $controller){
  if(!isset($args['id'])){
    $response->getBody()->write('403 - Forbidden!');
    return $response;
  }

  $id = $args['id'];
  $quiz = $view->displayQuizzData($id);
  $answers = array();
  $questions_set = array();

  
  $questions = $controller->retrieveQuizzQuestionID($quiz[0]['questions']);

  foreach($questions as $index => $question){
    $questions_set[] = $controller->getQuestionAttr($question)[0];

    $answers[$index] = $controller->retrieveQuestionAnswers($question);
    
    }

  // $response->getBody()->write(json_encode($quiz[0]));
  // return $response;


  // $response->getBody()->write(json_encode($answers[0][0]['title']));
  // return $response;

  echo $twig->render('quizzy.php', array(
    'quiz_data' => $quiz[0],
    'questions' => $questions_set,
    'answers' => $answers
  ));

  return $response;
});

//! evaluate user completed quiz
$app->post('/results', function($request, $response, $args) use($controller){
  session_start();
  $userID = $_SESSION['user_id'];
  $data = $_POST['data'];
  $id = $_POST['quiz'];

  $message = [
    'quiz' => $id,
    'data' => $data
  ];

  $message['data'] = explode(",", $message['data']);
  $userScore = $controller->evaluateQuiz($id, $message['data']);
 
  $controller->storeQuizResult($userID, $id, $userScore);

  return $response->withHeader('Location', 'http://localhost/Quizzy/app/quizzes')->withStatus(301);
});

$app->post('/question', function($request, $response) use($controller){
  session_start();
  if(isset($_POST['sa-text'])){

    $title = $_POST['question_title'];
    $type = 'sa-text';
    $score = (float)$_POST['score'];
    $owner = (int)$_SESSION['user_id'];

    $controller->addQuestion($title, $type, $score, $owner);
    $question = $controller->getQuestion($owner, $title, $type);

    $id_question = $question[0]['id'];

    $answer_title = $_POST['sa-text'];
    $controller->addAnswer($id_question, $answer_title);

    $hidden = 1;
    $answer_data = $controller->answerID($answer_title, $id_question);
    $id_answer = $answer_data[0]['id'];
  
    $controller->addCorrectAnswer($id_question, $id_answer, $hidden);

    $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app/question')->withStatus(301);
    return $newResponse;
  }
  
  if(isset($_POST['sa-mark'])){
    $response->getBody()->write('SA-MARK Question');
    $owner = (int)$_SESSION['user_id'];
    $title = $_POST['question_title'];
    $type = 'sa-mark';
    $score = (float)$_POST['score'];

    $hidden = 0;

    $controller->addQuestion($title, $type, $score, $owner);
    $question = $controller->getQuestion($owner, $title, $type);
    $id_question = $question[0]['id'];

    $answers_title = $_POST['sa-mark_answer'];
    foreach($answers_title as $answer){
      $controller->addAnswer($id_question, $answer);
    }

    $correct_answer = $_POST['correct'];
    $answer_data = $controller->answerID($correct_answer, $id_question);
    $id_answer = $answer_data[0]['id'];
    $controller->addCorrectAnswer($id_question, $id_answer, $hidden);

    $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app/question')->withStatus(301);
    return $newResponse;
  }

  if(isset($_POST['ma-checkbox'])){
    $response->getBody()->write('Multiple Answer Question');
    $owner = (int)$_SESSION['user_id'];
    $title = $_POST['question_title'];
    $type = 'ma-checkbox';
    $score = (float)$_POST['score'];

    $hidden = 0;

    $controller->addQuestion($title, $type, $score, $owner);
    $question = $controller->getQuestion($owner, $title, $type);
    $id_question = $question[0]['id'];

    $total_answers = $_POST['ma-checkbox_answer'];
    foreach($total_answers as $answer){
      $controller->addAnswer($id_question, $answer);
    }

    $total_correct = $_POST['correct'];
    foreach($total_correct as $correct){
      $answer_data = $controller->answerID($correct, $id_question);
      $id_answer = $answer_data[0]['id'];
      $controller->addCorrectAnswer($id_question, $id_answer, $hidden);
    }

    $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app/question')->withStatus(301);
    return $newResponse;
  }

  return $response;
});

$app->post('/quizz/options', function($request, $response, $args) use($view){
  session_start();
  if($_POST['question_type'] === 'user_questions'){
    $message = array();
    $userQuestions = $view->displayUserQuestions($_SESSION['user_id']);
    foreach($userQuestions as $option){
    
      $message[] = [
        'id' => $option['id'],
        'title' => $option['title'],
      ];
  }

    // $response->getBody()->write(json_encode($_POST['question_type']));
    $response->getBody()->write(json_encode($message));
    return $response;
  }

  if($_POST['question_type'] === 'total_questions'){
    $message = array();
    $questions = $view->displayQuestions();
    foreach($questions as $option){
      $message[] = [
        'id' => $option['id'],
        'title' => $option['title'],
      ];
    }

    $response->getBody()->write(json_encode($message));
    return $response;

  }

  $response->getBody()->write(json_encode('Wrong Request!'));
  return $response;

});

$app->post('/quizzes', function($request, $response, $args) use($controller){
  session_start();

  if(!isset($_POST['title'], $_POST['selected_options'])){
    $response->getBody()->write('404 - missing data');
    return $response;
  }

  //! use controller to store data efficiently
  $title = $_POST['title'];
  $options = $_POST['selected_options'];
  $questions = $controller->getOptions($options);
  
  $owner = $_SESSION['user_id']; 

  $controller->addQuiz($title, $questions, $owner);

  $newResponse = $response->withHeader('Location', 'http://localhost/Quizzy/app/quiz')->withStatus(301);
  return $newResponse;

});

// *!* documentation

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"Users"},
 *     @OA\Response(response="200", description="Registered Users"),
 *     @OA\Response(response="404", description="No Users Found")
 * )
 */

$app->get('/docs/users', function($request, $response) use($view){
  $users = $view->displayUsers();
  $response->getBody()->write(json_encode($users));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/users/{userID}/questions",
 *     description="Returns questions created by an user",
 *     tags={"Users"},
 *     @OA\Parameter(
 *      description="Selected user",
 *      in="path",
 *      name="userID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="User not found")
 * )
 */

$app->get('/docs/users/{userID}/questions', function($request, $response, $args) use($view){
  $id = $args['userID'];
  $userQuestions = $view->displayUserQuestions($id);
  $response->getBody()->write(json_encode($userQuestions));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Post(
 *     path="/users", tags = {"Users"},
 *     summary="Register",
 *     description="Register Account",
 *   @OA\RequestBody(
 *      @OA\MediaType(
 *          mediaType = "multipart/form-data",
 *          @OA\Schema(required = {"username", "password", "password-confirm"}, 
 *          @OA\Property(property = "username", type = "string"),
 *          @OA\Property(property = "password", type = "password"),
 *          @OA\Property(property = "password-confirm", type = "password")
 *                                            
 *              )
 *      )
 * ),
 *   @OA\Response  (response="200", description="New Account Registered"),
 *   @OA\Response  (response="400", description="Invalid Credentials")
 * )
 */

$app->post('/docs/users', function($request, $response) use($controller){
  if(isset($_POST['username'], $_POST['password'], $_POST['password-confirm']) &&
    $_POST['password'] === $_POST['password-confirm']){
      $username = $_POST['username'];
      $password = $_POST['password'];
      $controller->register($username, $password);
      $message = 'Account Registered';

      $response->getBody()->write(json_encode($message));
      return $response->withHeader('Content-Type', 'application/json');
  } 

  $message = 'Bad Credentials!';
  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/questions",
 *     tags={"Questions"},
 *     @OA\Response(response="200", description="Questions Available")
 * )
 */

$app->get('/docs/questions', function($request, $response) use($view){
  $message = $view->displayQuestions();
  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Post(
 *     path="/questions", tags = {"Questions"},
 *     description="Add Question",
 *   @OA\RequestBody(
 *      @OA\MediaType(
 *          mediaType = "multipart/form-data",
 *          @OA\Schema(required = {"title", "question_type", "score"}, 
 *          @OA\Property(property = "title", type = "string"),
 *          @OA\Property(property = "question_type", type = "string"),
 *          @OA\Property(property = "score", type = "integer")
 *                                            
 *              )
 *      )
 * ),
 *   @OA\Response  (response="200", description="Added New Question"),
 *   @OA\Response  (response="400", description="Invalid Input")
 * )
 */

$app->post('/docs/questions', function($request, $response, $args){
  $message = '200 - Question Added';
  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});


/**
 * @OA\Put(
 *     path="/questions/{questionID}", tags = {"Questions"},
 *     description="Edit Question",
 *   @OA\Parameter(
 *    description="Selected Question for Edit",
 *    in="path",
 *    name="questionID",
 *    required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )  
 *   ),
 *   @OA\RequestBody(
 *      @OA\MediaType(
 *          mediaType = "multipart/form-data",
 *          @OA\Schema(required = {"title", "question_type", "score"}, 
 *          @OA\Property(property = "title", type = "string"),
 *          @OA\Property(property = "question_type", type = "string"),
 *          @OA\Property(property = "score", type = "integer")
 *                                            
 *              )
 *      )
 * ),
 *   @OA\Response  (response="200", description="Added New Question"),
 *   @OA\Response  (response="400", description="Invalid Input")
 * )
 */

$app->put('/docs/questions', function($request, $response, $args){
  $message = '200 - Question Added';
  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});


/**
 * @OA\Delete(
 *     path="/questions/{questionID}/users/{userID}",
 *     description="Remove user created question",
 *     tags={"Questions"},
 *     @OA\Parameter(
 *      description="User Selected",
 *      in="path",
 *      name="questionID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Parameter(
 *     description="Question Selected",
 *      in="path",
 *      name="userID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="User or Question not found")
 * )
 */

$app->delete('/docs/questions/{questionID}/users/{userID}', function($request, $response, $args) use($controller){
  $id_user = $args['userID'];
  $id_question = $args['questionID'];
  
  $questionAttributes = $controller->getQuestionAttr($id_question);
  if(!$questionAttributes){
    $message = '404 - Question Not Found';
    
    $response->getBody()->write(json_encode($message));
    return $response->withHeader('Content-Type', 'application/json');
  }

  $controller->deleteUserQuestion($id_user, $id_question);
  $message = [
    'Server' => '200 - OK (Deleted Question)',
    'user' => $id_user,
    'question' => $id_question,
  
  ];
  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/answers/questions/{questionID}",
 *     description="Returns answers associated to a question",
 *     tags={"Answers"},
 *     @OA\Parameter(
 *      description="Selected Question",
 *      in="path",
 *      name="questionID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Answers not found")
 * )
 */

$app->get('/docs/answers/questions/{questionID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Display answers)',
    'Question ID' => $args['questionID'],
    'Answers: ' => '...'
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Post(
 *     path="/answers/{answersList}/questions/{questionID}",
 *     description="Assign possible answers to question",
 *     tags={"Answers"},
 *     @OA\Parameter(
 *      description="Selected Question",
 *      in="path",
 *      name="questionID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Answers not found")
 * )
 */

$app->post('/docs/answers/{answersList}/questions/{questionID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Display answers)',
    'Question ID' => $args['questionID'],
    'Answers: ' => '...'
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Put(
 *     path="/answers/{answersList}/questions/{questionID}",
 *     description="Assign possible answers to question",
 *     tags={"Answers"},
 *     @OA\Parameter(
 *      description="Selected Question",
 *      in="path",
 *      name="questionID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Answers not found")
 * )
 */

$app->put('/docs/answers/{answersList}/questions/{questionID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Update answers)',
    'Question ID' => $args['questionID'],
    'Updated Answers: ' => '...'
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Delete(
 *     path="/answers/{answersList}/questions/{questionID}",
 *     description="Assign possible answers to question",
 *     tags={"Answers"},
 *     @OA\Parameter(
 *      description="Selected Question",
 *      in="path",
 *      name="questionID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Answers not found")
 * )
 */

$app->delete('/docs/answers/{answersList}/questions/{questionID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Delete answers)',
    'Question ID' => $args['questionID'],
    
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/quizzes",
 *     description="Returns available quizzes",
 *     tags={"Quizzes"},
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Quizzes not found")
 * )
 */

$app->get('/docs/quizzes', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Display available quizzes)',
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/quizzes/{quizzID}",
 *     description="Returns answers associated to a question",
 *     tags={"Quizzes"},
 *     @OA\Parameter(
 *      description="Selected Question",
 *      in="path",
 *      name="quizzID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Quizz not found")
 * )
 */

$app->get('/docs/quizzes/{quizzID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK',
    'Quizz ID: ' => $args['quizzID'],
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Post(
 *     path="/quizzes",
 *     description="Create Quizz",
 *     tags={"Quizzes"},
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Invalid Input")
 * )
 */

$app->post('/docs/quizzes', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Quizz created)',
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Put(
 *     path="/quizzes/{quizzID}",
 *     description="Edit Quizz",
 *     tags={"Quizzes"},
 *     @OA\Parameter(
 *      description="Selected Quizz",
 *      in="path",
 *      name="quizzID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Quizz not found")
 * )
 */

$app->put('/docs/quizzes/{quizzID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Updated Quizz)',
    'Quizz ID: ' => $args['quizzID'],
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Delete(
 *     path="/quizzes/{quizzID}",
 *     description="Delete Quizz",
 *     tags={"Quizzes"},
 *     @OA\Parameter(
 *      description="Selected Quizz",
 *      in="path",
 *      name="quizzID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="Quizz not found")
 * )
 */

$app->delete('/docs/quizzes/{quizzID}', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Deleted Quizz)',
    'Quizz ID: ' => $args['quizzID'],
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

/**
 * @OA\Get(
 *     path="/quizzes/{quizzID}/users/{userID}/results",
 *     description="Returns score earned by a specific user within selected quizz",
 *     tags={"Quizzes"},
 *     @OA\Parameter(
 *      description="Quizz Selected",
 *      in="path",
 *      name="quizzID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Parameter(
 *     description="User Selected",
 *      in="path",
 *      name="userID",
 *      required=true,
 *      @OA\Schema(
 *        type="integer",
 *        format="int64",
 *      )
 *     ),
 *     @OA\Response(response="200", description="OK"),
 *     @OA\Response(response="404", description="User or Question not found")
 * )
 */

$app->get('/docs/quizzes/{quizzID}/users/{userID}/results', function($request, $response, $args){
  $message = [
    'Server' => '200 - OK (Deleted Quizz)',
    'Quizz ID: ' => $args['quizzID'],
    'User ID:' => $args['userID'],
    'Score: ' => '[result]'
  ];

  $response->getBody()->write(json_encode($message));
  return $response->withHeader('Content-Type', 'application/json');
});

$app->addErrorMiddleware(true, true, true);
$app->run();

?>