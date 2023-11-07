/*
! must be declared before being called -> ES 6  block level scope
 */


// + icon interactions
let addQuestionType = (e) => {
  e.preventDefault();
  e.target.style.cursor = 'pointer';
  // console.log('Pressed Interaction Button - ES6 !');
  
  // TODO: disable button when user clicks it <-> after choice is made must be re-enabled
  e.target.style.display = 'none';

  let questionOptions = document.querySelector('.dropdown-question_type');
  // questionOptions.style.display = 'block';
  questionOptions.style.display = 'block';
}

// single answer - text 
let answerText = (e) => {
  e.preventDefault();
  
  let hideMenu = document.querySelector('.dropdown-question_type');
  hideMenu.style.display = 'none';
  // addQuestion.style.display = 'inherit';
  let answers = document.querySelector('.answers');
  let inputField = document.createElement('input');

  // type text -> default 
  inputField.setAttribute('type', 'text');
  inputField.setAttribute('class', 'sa-text');
  inputField.setAttribute('name', 'sa-text');
  inputField.autocomplete = 'off';
  
  answers.appendChild(inputField);

  let header = document.querySelector('.header-add_answers');
  header.innerHTML = `Add Answer`;

  inputField.addEventListener('input', (e) => {
    let containerScore = document.querySelector('.container-score');
    containerScore.style.display = 'block';
    
  });

  

  let containerSubmit = document.querySelector('.container-submit');
  containerSubmit.style.display = 'block';
  
}

// single answer - mark from a list of answers the correct one.
let answerMark = (e) => {
  e.preventDefault();

  let hideMenu = document.querySelector('.dropdown-question_type');
  hideMenu.style.display = 'none';

  var answers = document.querySelector('.answers');
  let message = document.createElement('h1');
  
  message.innerHTML = `Nr. Of Answers(0-10)`;

  answers.appendChild(message);
  
  let inputField = document.createElement('input');
  
  // type text -> default 
  inputField.setAttribute('type', 'number');
  inputField.setAttribute('class', 'sa-mark');
  inputField.setAttribute('name', 'sa-mark');
  inputField.setAttribute('required', true);

  
  inputField.style.textAlign = 'center';
  answers.appendChild(inputField);

  
  inputField.addEventListener('input', (e) => {
  // console.log('Input Value: ' + inputField.value);
  inputField.style.display = 'none';

  let nrOfAnswers = inputField.value;

  // on given value, create text-input fields for answers
  for(let i = 0; i < nrOfAnswers; i++){
    message.style.display = 'none';

    var answerField = document.createElement('input');
    answerField.setAttribute('type', 'text');
    answerField.setAttribute('class', 'sa-mark_answer');
    answerField.setAttribute('name', 'sa-mark_answer[]');
    answerField.setAttribute('required', true);
    answerField.setAttribute('autocomplete', "off");

    answers.appendChild(answerField);
    
  }

  let correctHeader = document.getElementById('correct-header');
  correctHeader.style.display = 'block';

  let correctBtn = document.getElementById('correct-btn');
  correctBtn.style.display = 'block';
  });

}


// similar to Mark-List
let multipleAnswers = (e) => {
  e.preventDefault();

  let hideMenu = document.querySelector('.dropdown-question_type');
  hideMenu.style.display = 'none';

  var answers = document.querySelector('.answers');
  let message = document.createElement('h1');
  
  message.innerHTML = `Nr. Of Answers (0-10)`;

  answers.appendChild(message);
  
  let inputField = document.createElement('input');
  
  // type text -> default 
  inputField.setAttribute('type', 'number');
  inputField.setAttribute('class', 'ma-checkbox');
  inputField.setAttribute('name', 'ma-checkbox');
  inputField.setAttribute('required', true);

  
  inputField.style.textAlign = 'center';
  answers.appendChild(inputField);

  inputField.addEventListener('input', (e) => {
    // console.log('Input Value: ' + inputField.value);
    inputField.style.display = 'none';
  
    let nrOfAnswers = inputField.value;
  
    // on given value, create text-input fields for answers
    for(let i = 0; i < nrOfAnswers; i++){
      message.style.display = 'none';
  
      var answerField = document.createElement('input');
      answerField.setAttribute('type', 'text');
      answerField.setAttribute('class', 'ma-checkbox_answer');
      answerField.setAttribute('name', 'ma-checkbox_answer[]');
      answerField.setAttribute('required', true);
      answerField.setAttribute('autocomplete', "off");
  
      answers.appendChild(answerField);
      
    }
  
    let correctHeader = document.getElementById('correct-header');
    correctHeader.style.display = 'block';
    correctHeader.innerHTML = `Correct Answers`;
  
    let correctBtn = document.getElementById('correct-btn');
    correctBtn.style.display = 'block';
    });
  

  
 
}

// correct answer list
let correct = (e) => {
  e.preventDefault();
  let menuHide = document.querySelector('.container-answers');
  menuHide.style.display = 'none';

  let list = document.querySelector('.list-correct');
  var ul = document.createElement('ul');
  ul.setAttribute('class', 'correct-answer_list');
  ul.setAttribute('name', 'correct-answer_list');

  list.appendChild(ul);

  // var answerFields = document.querySelectorAll('.sa-mark_answer');
  var answerFields = [];
  if(document.querySelectorAll('.sa-mark_answer').length === 0){
    answerFields = document.querySelectorAll('.ma-checkbox_answer');
    console.log(document.querySelectorAll('.ma-checkbox_answer'));
  }else{
    answerFields = document.querySelectorAll('.sa-mark_answer');
    // console.log(document.querySelectorAll('.sa-mark_answer'));
  }
  
  answerFields.forEach(element => {
    var li = document.createElement('li');
    li.setAttribute('name', 'correct-answer_list-item');
    li.setAttribute('class', 'correct-answer_list-item');
    li.innerHTML = `${element.value}`;

    if(document.querySelectorAll('.sa-mark_answer').length !== 0){
    // keep selected option as correct answer, eliminate other options from mark list
    li.addEventListener('click', (e) => {
      // console.log(e.target.innerHTML);
      var selectedOption = e.target.innerHTML;
      selectedOption.toString();
      
      var list = document.querySelectorAll('.correct-answer_list-item');

      
      list.forEach(element => {
        
        if(element.innerHTML.toString() === selectedOption){
          console.log(`Selected Option: ${selectedOption}`);
          element.setAttribute('class', 'btn');
          element.style.cursor = 'initial';

          let option = document.createElement('input');
          option.setAttribute('name', 'correct');
          option.value = selectedOption;
          option.style.display = 'none';

          ul.appendChild(option);

          let showMenu = document.querySelector('.container-score');
          showMenu.style.display = 'block';

        }else{
          console.log(`Element pentru stergere: ${element.innerHTML}`);
          // ul.removeChild(element);
          element.style.display = 'none';
        }
      });
    });
    
    //! ma-checkbox -> multiple answers
  }else{
    li.addEventListener('click', (e) => {
      // console.log(e.target.innerHTML);
      var selectedOption = e.target.innerHTML;
      selectedOption.toString();
      
      var list = document.querySelectorAll('.correct-answer_list-item');

      
      list.forEach(element => {
        
        if(element.innerHTML.toString() === selectedOption){
          console.log(`Selected Option: ${selectedOption}`);
          
          element.setAttribute('class', 'answer btn-correct[]');
          // element.setAttribute('name', '');
          element.style.cursor = 'initial';
          element.style.background = 'rgba(255, 0, 0, 0.795)';
          element.style.color = '#fff';

          let option = document.createElement('input');
          option.setAttribute('name', 'correct[]');
          option.setAttribute('class', 'correct');
          option.value = selectedOption;
          option.style.display = 'none';

          // ul.appendChild(option);
          li.appendChild(option);

          // let showMenu = document.querySelector('.container-score');
          // showMenu.style.display = 'block';

        }else{
          console.log(`Element liber: ${element.innerHTML}`);
          
        
          // ul.removeChild(element);
          // element.style.display = 'none';
        }
      });
      

    });
  }
    ul.appendChild(li);

    // element.disabled = true;
    // element.style.background = '#fff';

  });
  
  btn = document.getElementById('correct-btn');
  btn.style.display = 'none';

  if(document.querySelectorAll('.ma-checkbox_answer').length !== 0){

  var saveBtn = document.createElement('button');
  saveBtn.innerText = `Save`;
  saveBtn.setAttribute('class', 'btn');
  saveBtn.setAttribute('type', 'button');
  document.querySelector('.list-correct').appendChild(saveBtn);


  // ! keep selected asnwers, remove the others
  saveBtn.addEventListener('click', (e) =>{
    console.log('Here: \n');
    console.log(document.querySelectorAll('.answer').length);
    const choice = document.querySelectorAll('.answer').length;
    var ul = document.querySelector('.correct-answer_list');
    

    if(choice === 0){
     
      console.log(`NO SELECTION!`);
      if(!document.querySelector('.warning')){
        let message = document.createElement('p');
        message.setAttribute('class', 'warning');
        message.innerHTML = `Selected Answer Required!`;

        ul.appendChild(message);
      }
    }else{
      // console.log(document.querySelectorAll('.btn-correct').length);

    // var ul = document.querySelector('.correct-answer_list');
     console.log(ul.childNodes);
    
    var displayElements = ul.childNodes;
    console.log(`ul children: ${displayElements}`);
  
    for(let i = 0; i < displayElements.length; i++){
      
      if(displayElements[i].getAttribute('class') !== 'answer btn-correct[]'){
        console.log('found threat');
        // ul.removeChild(displayElements[i]);
       
        // console.log(displayElements[i]);
        console.log(displayElements[i].parentNode);
        displayElements[i].parentNode.removeChild(displayElements[i]);
        
        // console.log(displayElements[i].parentNode.parentNode);
      
        //! counter must be drecremented in order to not jump over the elements of new sized NODE
        /* 
          ! once the element is removed, on that position a new element is assigned
          !! it is necesessary to reiterate !
        */
        i --; 
      }

      
      saveBtn.style.display = 'none';
       let scoreMenu = document.querySelector('.container-score');
       scoreMenu.style.display = 'block';
    }

    console.log(ul.childElementCount);
  

      // opposite of event.preventDefault();
      
    }
  });
}
  
}

let score = (e) => {
  let scoreNumber = e.target.value;
  if(scoreNumber > 0 && scoreNumber <= 10){
    console.log('Execute something...' + 'score: ' + scoreNumber);
    let submitForm = document.querySelector('.container-submit');
    submitForm.style.display = 'block';
  }
}

/* 
TODO: correct answer, select from the list of answers entered on answer fields
     -> might be necessary to have a button for saving answers 
*/
let addQuestion = document.getElementById('interactions-btn');
addQuestion.addEventListener('click', addQuestionType);

let singleAnswerText = document.querySelector('.answer_text');
singleAnswerText.addEventListener('click', answerText);

let singleAnswerMark = document.querySelector('.answer_mark');
singleAnswerMark.addEventListener('click', answerMark);

let answerMultiple = document.querySelector('.answer_multiple');
answerMultiple.addEventListener('click', multipleAnswers);

let correctAnswer = document.getElementById('correct-btn');
correctAnswer.addEventListener('click', correct);

let questionScore = document.querySelector('.score');
questionScore.addEventListener('input', score);
