let questionType = (e) => {
  e.preventDefault();
  e.target.style.display = 'none';

  // create option buttons
  let option = document.querySelector('.interactions');
  option.style.display = 'block';
}

let saveSelection = (e) => {
  e.preventDefault();
  console.log('save button pressed');

  let choices = document.querySelectorAll('.user_questions');
  // console.log(choices[0].innerHTML);
  let selected = document.querySelectorAll('.selected_options');
  console.log('Selected: ' + selected[0].value);

  for(let i = 0; i < choices.length; i++){
    var found = false;
    console.log(choices[i].innerHTML);
    selected.forEach(selection => {
     
      if(choices[i].innerHTML === selection.value){
        console.log('Element: ' + choices[i].innerHTML);
        console.log('Selection: ' + selection.value);
        found = true;

        let selectedOptionID = document.createElement('input');
        console.log(totalQuestions);


        quizzQuestions = document.querySelector('list-correct');
        selectedQuestions = document.querySelectorAll('.user_questions');
        // console.log(selectedQuestions);
        // selectedQuestions.forEach(option => {
        //   let selectedOptionID = document.createElement('input');
        //   selectedOptionID.value = option;
        //   console.log('HERE@##$');
        //   console.log(selectedOptionID);
        // });
        

      }    
    });

    if(found === false){
      choices[i].parentNode.removeChild(choices[i]);
    }
  }

  submitBtn = document.querySelector('.btn-submit');
  submitBtn.style.display = 'block';

  e.target.style.display = 'none';

  var data = document.createElement('input');
  data.setAttribute('name', 'quiz_data');
  data.value = 'quiz_data';
  data.style.display = 'none';

  var questions = document.querySelector('.questions');
  questions.appendChild(data);
  
}

let selectedOption = (e) => {
  e.preventDefault();
  // console.log('\nMethod Accessed!\n');
  optionValue = e.target.innerHTML;
  console.log('Option Value: ' + optionValue);

  // DOM
  var selection = document.createElement('input');
  selection.setAttribute('class', 'selected_options');
  selection.setAttribute('name', 'selected_options[]');
  selection.value = optionValue;
  
  selection.style.display = 'none';

  var list = document.querySelector('.questions');
  list.appendChild(selection);

  e.target.style.background = 'rgba(255, 0, 0, 0.795)';
  e.target.style.color = '#fff';
  e.target.style.cursor = 'initial';

  // ! prevent duplicate choices
  e.target.removeEventListener("click", selectedOption);
  
  saveBtn = document.querySelector('.btn-save');
  saveBtn.style.display = 'block';

  saveBtn.addEventListener('click', saveSelection);

  // ! iterate the list -> save selection -> submit
}

let totalQuestions = (e) => {
  e.preventDefault();
  console.log('questions pressed!');

  let hideMenu = document.querySelector('.dropdown-question_type');
  hideMenu.style.display = 'none';

  let questions = document.querySelector('.questions');

  var xhr = new XMLHttpRequest();

  //* 3rd param = async request on/off
  xhr.open('POST', 'http://localhost/Quizzy/app/quizz/options', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function(){
    console.log(this.responseText);
    var data = JSON.parse(this.responseText);
    // console.log(data);
    for(var i = 0; i < data.length; i++){
      // console.log(data[i]);
      // console.log(data[i].title);
      let option = document.createElement('li');
      option.setAttribute('class', 'user_questions');
      option.innerHTML = data[i].title;
      option.addEventListener('click', selectedOption);

      let optionID = document.createElement('input');
      optionID.setAttribute('name', 'questionID');
      optionID.value = data[i].id;
      
      optionID.style.display = 'none';

      questions.appendChild(option);
      questions.appendChild(optionID);
    }
  }
  var type = 'total_questions';
  xhr.send('question_type=' + encodeURIComponent(type));
}

let userQuestions = (e) => {
  e.preventDefault();
  console.log('MyQuestions pressed!');

  let hideMenu = document.querySelector('.dropdown-question_type');
  hideMenu.style.display = 'none';

  let questions = document.querySelector('.questions');

  var xhr = new XMLHttpRequest();

  //* 3rd param = async request on/off
  xhr.open('POST', 'http://localhost/Quizzy/app/quizz/options', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function(){
    console.log(this.responseText);
    var data = JSON.parse(this.responseText);
    // console.log(data);
    for(var i = 0; i < data.length; i++){
      // console.log(data[i]);
      // console.log(data[i].title);
      let option = document.createElement('li');
      option.setAttribute('class', 'user_questions');
      option.innerHTML = data[i].title;
      option.addEventListener('click', selectedOption);

      let optionID = document.createElement('input');
      optionID.setAttribute('name', 'questionID');
      optionID.value = data[i].id;

      optionID.style.display = 'none';

      questions.appendChild(option);
      questions.appendChild(optionID);
    }
  }
  var type = 'user_questions';
  xhr.send('question_type=' + encodeURIComponent(type));
 
}

let addQuestions = document.getElementById('add-questions');
addQuestions.addEventListener('click', questionType);

let myQuestions = document.querySelector('.myQuestions');
myQuestions.addEventListener('click', userQuestions);

let questions = document.querySelector('.totalQuestions');
questions.addEventListener('click', totalQuestions);
