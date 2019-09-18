var user_input = []; //array to store choices user made
var answers = []; //array to store answers of each questions
var score = 0; //user's score
var q_length = 0; //amount of questions

function parseQuizjs(quizdata) {
  var output = [];
  q_length = quizdata.length;
  for (var i=0;i < quizdata.length;i++){
    var choices_temp = [];
    var inquiry = quizdata[i]['inquiry'];
    var answer = quizdata[i]['answer'];
    var choices = quizdata[i]['choices'];


    for (var j=0; j < choices.length; j++){
      choices_temp.push( '<input type="radio" name="q'+(i+1)+'" value='+j +' required>' + String.fromCharCode(97+j) + '. '
                + choices[j] + '<br>' );
      if (choices[j] == answer) {
        answers[i] = j;
      }
    }
    output.push( '<form id="question' + (i+1) + '">' + (i+1) + '. ' + inquiry
                + '<br>' + choices_temp.join('') + '</form><br/>');
                // write to HTML doc to create each question and answers
  }

  document.getElementById("quizPreview").innerHTML = output.join('');
}

function get_answers() {
  user_input = [];
  for (var i = 0; i < q_length; i++) {
    var checked = document.querySelector('[name="q' + (i+1) + '"]:checked');
    user_input.push(checked.value);
  }
}

function display_answers(ans) {
  var temp = [];
  for (var i = 0; i < ans.length; i++){
    temp.push(String.fromCharCode(97+parseInt(ans[i]))); //display the correct answers by converting the number to its respective character code (eg, 0 -> a).
    //Makes it more readable for the user.
  }
  return temp;
}

function show_score() {
 try {
   score = 0; // reinitialize score each time the submit button is pressed.
   get_answers();
   calculate_score();
   console.log(user_input);
   console.log('userinput');

   document.getElementById("results").innerHTML = 'Your score is: ' + score + '/' + q_length + ' or ' + Math.round((score / q_length) * 100) + '%' +
                               "<br/>Correct answers are: " + display_answers(answers);
   document.getElementById("results").style.display = "block";
 } catch {
   alert("Please answer all the questions."); //return an error if all questions are not answered.
 }
}

function calculate_score() {
  for (var i = 0; i < user_input.length; i++) {
    if (user_input[i] == answers[i]){
      score++; // calculate score by increasing the count by one each time the user_input matches the answer
    }
  }

}
