// instructor.js
// handles javascript for instructor's personal pages

$(document).ready(function(){
  $("#logout").on('click', function() {
    window.location = "../shared/logout.php";
  });
  $("#create_course").on('click', function() {
    window.location = "createcourse.php";
  });
})

$(".del_btn").on('click', function() {
  var course_id = this.parentElement.id;
  alert("Deleting course.");
  $.ajax({
    type: 'POST',
    url: 'index.php',
    data: {'delcourse': course_id}
  });
  window.location.reload();
});


$(".edit_btn").on('click', function() {
  var course_id = this.parentElement.id;
  $.ajax({
    type: 'POST',
    url: 'index.php',
    data: {'editcourse': course_id}
  });
  window.location = "editcourse.php";
});

$("#changecoursename").on('click', function(){
  var new_name = document.getElementById("new_course_name").value;
  alert("Changing course name.");
  $.ajax({
    type:'POST',
    url: 'index.php',
    data: {'changecoursename': new_name}
  });
  window.location.reload();
});

$(".del_unit_btn").on('click', function() {
  var unit_id = this.parentElement.id;
  $.ajax({
    type:'POST',
    url: 'editcourse.php',
    data: {'delunit': unit_id}
  });
  alert("Unit will be deleted.");
  window.location = "editcourse.php";
});

$(".edit_unit_btn").on('click', function() {
  var unit_id = this.parentElement.id;
  $.ajax({
    type:'POST',
    url: 'editcourse.php',
    data: {'editunit': unit_id}
  });
  window.location = "editunit.php";
});


$(".del_lesson_btn").on('click', function() {
  var lesson_id = this.parentElement.id;
  $.ajax({
    type:'POST',
    url: 'editunit.php',
    data: {'dellesson': lesson_id}
  });
  alert("Lesson will be deleted.");
  window.location = "editunit.php";
});

$(".edit_lesson_btn").on('click', function() {
  var lesson_id = this.parentElement.id;
  $.ajax({
    type:'POST',
    url: 'editunit.php',
    data: {'editlesson': lesson_id}
  });
  window.location = "editlesson.php";

});

$("#savelessonbtn").on('click', function(){
  var lessonxml = document.getElementById("lessonxml").value;
  $.ajax({
    type:'POST',
    url: 'editlesson.php',
    data: {'savelesson': lessonxml}
  });
  window.location = "editlesson.php";
});

$("#savequizbtn").on('click', function(){
  var quizxml = document.getElementById("quizxml").value;
  $.ajax({
    type:'POST',
    url: 'editlesson.php',
    data: {'savequiz': quizxml}
  });
  window.location = "editlesson.php";
});

function toggleText(id) {
  var element = document.getElementById(id);
  if(element.style.display == 'block'){
    element.style.display = 'none';
  }else {
    element.style.display = 'block';
  }
}
