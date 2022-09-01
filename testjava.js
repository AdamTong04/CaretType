//initialise global variables
var caret = 0;
var typed = "";
const list = ["the","at","there","some","my","of","be","use","her","than","and","this","an","would","first","a","have","each","make","water","to","from","which","like","been","in","or","she","him","call","is","one","do","into","who","you","had","how","time","that","by","their","has","its","it","word","if","look","now","he","but","will","two","find","was","not","up","more","long","for","what","other","write","down","on","all","about","go","day","are","were","out","see","did","as","we","many","number","get","with","when","then","no","come","his","your","them","way","made","they","can","these","could","may"];
var contents = "";
var incorrect = "";
var item = "";
var incorrectCount = 0;
var correct = 0;
var wordsPM = 0;
var totalTime = 0;
var timerUp = 0;

// main code
function wpmCalculate() {
  // words per minute calculation
  wordsPM = (correct / 5) * (60/timerUp);
  // checks if the wpm is below zero; if so, set words per minute to zero
  if (wordsPM < 0){
    wordsPM = 0;
  }
  // insert the words per minute value into the form for PHP processing
  var wordsPerMinute = document.forms['wordsPerMinute']['wpm'];
  wordsPerMinute.setAttribute('value',wordsPM);
  // submitting the hidden form from javascript
  document.getElementById('submit-btn').click();
}

//starts a timer the moment the page loads
function time() {
  // set the total time the user has
  totalTime = sec
  // start the timer counting down from selected time limit
  var stopwatch = setInterval(function() {
    // count the time going up for the words per minute calculation
    timerUp++;
    // change the html code value for the time left to match the current time left
    document.getElementById("timer").innerHTML = sec;
    // count down one second
    sec--;
    // when the time reaches 0, run the words per minute calculation and stop the stopwatch
    if (sec == -01){
      wpmCalculate();
      clearInterval(stopwatch);
    }
    // loop ever 1000 milliseconds (one second)
  }, 1000);
}
//display the words inially before the user starts typing
function display(contents) {
  var content = contents;
  // change the words to be typed on the html page
  document.getElementById("untyped").innerHTML = content;
}
//looking for the user to input a key press
document.addEventListener('keydown', (event)=> {
  // save the key press
  var input = event.key;
  // identify the associated keycode for the key press
  var key = event.keyCode;
  // only if the key code is between a certain set of values, will the input be valid
  // this will sort out non-character key presses, and avoid extreme values from being passed into the code(F4)
  if ((key >= 65 && key <= 90) || key == 8 || key == 32){
    // run the module to check if the character inputted is correct(F4)
    caret = check(input,contents,caret);
  }
});

// module to create the random set of words
function create() {
  // loop 29 times
  for (let step = 0; step < 29; step++) {
    // select a random index from the list of words array and save it into a string variable
    contents = contents.concat(list[Math.floor(Math.random() * list.length)]);
    contents = contents.concat(" ");
  }
  // add one final word without the space at the end to improve typing experience
  contents = contents.concat(list[Math.floor(Math.random() * list.length)]);
  // run display function
  display(contents);
  // run time function
  time();
}


//letter validation and output to the screen (F9)
function check(input,contents,caret) {
  // set the current charcter to a variable
  var current = contents.substring(caret,caret+1);
  // refresh the typed words
  var untyped = contents.substring(caret+1);
  // condition to end the test and calculate the words per minute when the user finishes typing
  if (untyped.length == 0) {
    wpmCalculate();
  }
  // if the character matches the untyped character(F4)
  if (input == current && incorrectCount == 0) {
    // set the correctly typed word to powder blue and hide the error message
    document.getElementById("typed").style.color = "powderblue";
    document.getElementById("error").style.opacity = 0;
    // increment the correctly typed value
    typed = typed + input;
    // update the html code the match the current javascript for typed words
    document.getElementById("typed").innerHTML = typed;
    document.getElementById("untyped").innerHTML = untyped;
    // increment the correctly typed characters counter and the current position of the typing
    correct += 1;
    caret += 1;
    // condition to check if backspace has been pressed(F4)
  } else if (input == "Backspace") {
    // if the incorrectly typed words is more than one, reduce the value by one
    if (incorrectCount > 0) {
      incorrectCount -= 1;
      // reduce the characters typed incorrectly by one
      incorrect = incorrect.slice(0, -1);
      // update the html page to match the amount of incorrectly typed words
      document.getElementById("incorrect").innerHTML = incorrect;
      // remove the correct counter by one
      correct -= 1;
    }
  // if the typed character doesn't match the current character(F4)
  } else if (input != current){
    // if the amount of incorrectly typed words is less than one
    if (incorrectCount < 8) {
      // increase the counter for incorrect words by 1
      incorrectCount += 1
      // add the incorrectly typed character to the webpage
      incorrect = incorrect + input;
      // update the html page to match the amount of incorrectly typed words
      document.getElementById("incorrect").innerHTML = incorrect;
    }
    //The error message appears
    document.getElementById("error").style.opacity = 1;
    document.getElementById("typed").style.color = "#BA0000";

  }
  //condition to make sure the error doesn't display when the user has finished programming
  if (typed == contents) {
    document.getElementById("error").style.opacity = 0;
  }
  //condition to reset the colour to blue if the word is right
  if (incorrectCount == 0) {
    document.getElementById("typed").style.color = "powderblue";
    document.getElementById("error").style.opacity = 0;
  }
  // return the current character back
  return caret;
}
