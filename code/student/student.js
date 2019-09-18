// student.js
// handles javascript for student's personal pages

$(document).ready(function(){
  $("#logout").on('click', function() {
    window.location = "../shared/logout.php";
  });
  $("#register_course").on('click', function() {
    window.location = "registercourse.php";
  });
});

$(".course_btn").on('click', function() {
  var course_id = this.parentElement.id;
  $.ajax({
    type: 'POST',
    url: 'index.php',
    data: {'coursenavigation': course_id}
  });
  window.location = "coursepage.php";

});

function unit_select(unit_id) {
  $.ajax({
    type: 'POST',
    url: 'lessonselector.php',
    data: {'unitselection': unit_id}
  });
  $("#tutArea").load("lessonselector.php");
}

function lesson_select(lesson_id) {
  $.ajax({
    type: 'POST',
    url: 'lessonpage.php',
    data: {'lessonselection': lesson_id}
  });
  $("#tutArea").load("lessonpage.php");
}
