<?php
$servername = "localhost";
$username = "iw3htp";
$password = "password";

//carry over username from login to know which user is logged in
$uname = $_SESSION["uname"];
// create and connect to mysql server
if ( !( $database = mysqli_connect($servername, $username, $password)))
  die ("Could not connect to server");
// connecting to ecademy database
if ( !(mysqli_select_db( $database, "ecademydb")) )
  die ("Error connecting to the ecademydb database");

function parseLesson($xml) {
  global $uname;
  global $database;
  $xml = preg_replace(
    array('/<subsection>/', '/<\/subsection>/', '/<subtitle>/', '/<\/subtitle>/',
        '/<text>/', '/<\/text>/', '/<subsubsection>/', '/<\/subsubsection>/', '/<newline>/'),
    array('<div id="tutorial">', '</div>', '<h2 class="subsection">', '</h2>',
        '<p class="tut">', '</p>', '<p class="subsubsection">', '</p>', '</br>'),
    $xml
  );
  $regex = '/<image>([\s\S]*?)<\/image>/';
  preg_match_all($regex, $xml, $matches);
  $images = $matches[0];
  if ($images) {
    for ($i=0; $i<count($images);$i++){
      $imgname = getImgName($images[$i]);
      $query = "SELECT file FROM files WHERE filename='$imgname' and uname='$uname'";
      $result = mysqli_query( $database, $query);
      while ($row = $result->fetch_array()) {
        $xml = preg_replace(
          array('/<image>'.$imgname.'<\/image>/'),
          array('<img class="resize" src="data:image/png;base64,'.base64_encode($row['file']).'"/>'),
          $xml
        );
      }
      if (mysqli_num_rows($result) == 0){
        $xml = preg_replace(
          array('/<image>'.$imgname.'<\/image>/'),
          array('IMAGE "'.$imgname. '" DOES NOT EXIST'),
          $xml
        );
      }
    }
  }
  return $xml;
}

function parseQuiz($xml) {
  $result = array();
  $regex = '/<question>([\s\S]*?)<\/question>/';
  preg_match_all($regex, $xml, $matches);
  $questions = $matches[0];
  for ($i=0; $i<count($questions);$i++) {
    preg_match('/(<inquiry>([\s\S.]*?)<\/inquiry>)/', $questions[$i], $matches);
    $temparray['inquiry'] = $matches[0];
    preg_match('/(<answer>([\s\S.]*?)<\/answer>)/', $questions[$i], $matches);
    $temparray['answer'] = $matches[0];
    preg_match_all('/(<choice>([\s\S.]*?)<\/choice>)|(<answer>([\s\S.]*?)<\/answer>)/',$questions[$i], $matches);
    $temparray['choices'] = $matches[0];
    array_push($result, $temparray);
  }
  return $result;
}

function getImgName($string) {
  $string = ' ' . $string;
  $start = strpos($string, '<image>');
  if ($start == 0) return '';
  $start += strlen('<image>');
  $end = strpos($string, '</image>', $start) - $start;
  return substr($string, $start, $end);
}

/*
<question>
  <inquiry>What is the specialized software that responds to the client's requests?</inquiry>
  <answer>web server</answer>
  <choice>website</choice>
  <choice>web domain</choice>
  <choice>internet</choice>
</question>
*/
?>
