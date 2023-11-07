let saveSelection = (e) => {
  e.preventDefault();
  let totalSelections = document.getElementById('user_answers'); 
  var selection = e.target.innerHTML;

  // let questionAnswerSelection = document.querySelector('.answers')
  questionDataContainer = e.target.parentNode;
  
  lastChild = questionDataContainer.lastChild;
  
  containerAnswers = lastChild.previousSibling;
  console.log(containerAnswers);
  
  // ! test zone
  // console.log(e.target.getAttribute('class'));
  // !
  var questionType = e.target.getAttribute('class');

  // TODO: assign data to inputs which will be sent to evaluator, data(answers sent will be verified on question they belong to)
  var userAnswer = document.createElement('input');
  userAnswer.setAttribute('class', 'hidden');

  if(questionType === 'sa-text answer'){
    e.target.addEventListener('blur', function(){
      userAnswer.setAttribute('name', 'sa-text_answers[]');
      userAnswer.value = e.target.value;
      e.target.disabled = true;

      // containerAnswers.appendChild(userAnswer);
    });
  }

  if(questionType === 'ma-checkbox answer'){
    userAnswer.setAttribute('name', 'ma-user_answers[]');
    userAnswer.value = selection;

    // containerAnswers.appendChild(userAnswer);
 
  }

  if(questionType === 'sa-mark answer'){
    userAnswer.setAttribute('name', 'sa-mark_answer[]');
    userAnswer.value = selection;

    // containerAnswers.appendChild(userAnswer);
    
    // prevent multiple answer on mark-list answer
    var list = document.querySelectorAll('.sa-mark');

    for(let i = 0; i < list.length; i++){
      // console.log(list[i]);
      if(list[i].innerHTML !== selection){
        list[i].parentNode.removeChild(list[i]);
      }
    }
    
  }

  containerAnswers.append(userAnswer);
  // totalSelections.appendChild(userAnswer);

  // prevent duplicates
  e.target.removeEventListener('click', saveSelection);

  e.target.style.color = '#fff';
  e.target.style.background = 'rgba(255, 0, 0, 0.795)';
  console.log(selection);
  console.log('User Answer: ' + userAnswer.value);
  
}

let formatData = (e) => {
  e.preventDefault();

  finalData = [];

  let questionContainers = document.querySelectorAll('.question');
  questionContainers.forEach(container => {
      console.log(container.childNodes);
      let attributes = container.childNodes;
      attributes.forEach((attribute, index) => {
        if(attribute.className){
          // console.log(attribute.className);
          switch(attribute.className){
            case 'question_id':
            finalData.push(['questionID', attribute.value]);
            break;

            case 'answers':
              
              answers = attribute.childNodes;

              answers.forEach(answer => {
                if(answer.value){
                  finalData.push(['answer', answer.value]);
                }
                // console.log('problem!!!');
                // console.log(answer);
                // console.log(' value ');
                // console.log(answer.value);
              });
              // console.log(attribute.childNodes);
            break;
          }
        }
      })
      
  });

  for(let i = 0; i < finalData.length; i++){
    console.log(finalData[i]);
    if(finalData[i][0] === 'questionID'){
      console.log("SPLIT HERE!");
    }
  }
  console.log('Array length final data: ' + finalData.length);
  console.log(finalData);

  // const final_data = {};
  // let totalSelections = document.getElementById('user_answers');
  // console.log(totalSelections);
  // let fillables = document.querySelectorAll('.sa-text');

  const id = document.getElementById('quizID').value;
  // let questionTypes = document.querySelectorAll('.question_type');
  // let questionIDs = document.querySelectorAll('.question_id');
  // var type = []; 
  // var questionID = [];
  // var answers = [];

  //! format data (questionID - type - answers ) questionID === answer.id
  // for(let i = 0; i < questionIDs.length; i++){
  //   questionID.push(questionIDs[i].value);
  //   type.push(questionTypes[i].value);
  // }

  //! retrieve user answers and format an array with data
  // const totalAnswers = document.getElementById("user_answers");
  // console.log("container answers: ");
  // console.log(totalAnswers);

  //! answers selected by user
  // for(let index = 0; index <= totalAnswers.childElementCount; index++){
  //   console.log(totalAnswers.childNodes[index].value);
    
  //   if(totalAnswers.childNodes[index].value){
  //     answers.push(totalAnswers.childNodes[index].value);
      
  //   }
  // }

  //! fillables (answers of type input box)
  // for(let index = 0; index < fillables.length; index++){
  //   // console.log("fillble found---" + fillables[index].value);
  //   answers.push(fillables[index].value);
  // }

  //! ajax request
  const data = new FormData();
  data.append('quiz', id);
  data.append('data', finalData);
  // data.append('quiz', id);
  // data.append('questions', questionID);
  // data.append('question_type', type);
  // data.append('answers', answers);

  var xhr = new XMLHttpRequest();
  const url = `http://localhost/Quizzy/app/results`;
  xhr.open('POST' , url, true);
  // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function(){
    console.log(this.responseText);
  }

  xhr.send(data);

}

let sanitizeQuiz = (e) => {
  e.preventDefault();

  // answersContainer = document.querySelectorAll('.answers');
  // answersContainer.forEach( answer => {
  //   console.log(answer.childElementCount);
  // });

  e.target.style = "display:none";
  submitBtn = document.getElementById('sub');
  submitBtn.style.display = "unset";
  submitBtn.addEventListener('click', function(){
    window.location.replace("http://localhost/Quizzy/app/quizzes");
  });
}

//!!!!!! add ajax functionality on submit button + UI for results !!!!!!!!

let quizSanitize = document.getElementById('save-btn');
quizSanitize.addEventListener('click', sanitizeQuiz)

let userAnswers = document.querySelectorAll('.answer');
userAnswers.forEach(answer => {
  answer.addEventListener('click', saveSelection);
});

let quizData = document.getElementById('quiz');
quizData.addEventListener('submit', formatData);

