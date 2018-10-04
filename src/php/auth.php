<?php

include_once 'sql.php';

if(isset($_POST["auth"])) {
  $login = trim(safe_query($_POST['login']));
  $pass = trim(safe_query($_POST['password']));
  $result = my_query("SELECT * FROM users WHERE login = '{$login}'", true) or die('Запрос не удался: ' . mysql_error());
  if($result->num_rows > 0){
    $line = $result->fetch_assoc();
    $hash = $line["pass_hash"];
    $checked = password_verify($pass, $line["pass_hash"]);
    if($checked){
      if (isset($_COOKIE['id'])) {
        unset($_COOKIE['id']);
        unset($_COOKIE['SESSION_HASH']);
        setcookie('id', null, -1, '/');
        setcookie('SESSION_HASH', null, -1, '/');
      }
      setcookie ("id", $line['id'], time() + 50000, '/');
      setcookie ("SESSION_HASH", md5($hash.md5($line['login'].$hash)), time() + 50000, '/');
      header("Location: ../../");
    } else {
      echo "<script>alert('wrong pass')</script>";
    }
  } else {
    echo "<script>alert('no such a user')</script>";
  }
}

function check($var){
  if($var == 1) {
    $header_location_logged = "../";
    $header_location_unlogged = "Location: ../login/";
  } else {
    $header_location_logged = "Location:";
    $header_location_unlogged = "Location: login/";
  }
  if(isset($_COOKIE["id"]) && isset($_COOKIE["SESSION_HASH"])) {
    $id = safe_query($_COOKIE["id"]);
    $result = my_query("SELECT * FROM users WHERE id = '{$id}'", true) or die('Запрос не удался: ' . mysql_error());
    if($result->num_rows > 0){
      $line = $result->fetch_assoc();
      $hash = $line["pass_hash"];
      $checked = $_COOKIE["SESSION_HASH"] == md5($hash.md5($line['login'].$hash));
      if($checked){
        // ok
        return true;
      } else {
        // wrong pass
        return false;
      }
    } else {
      // no such a user
      return false;
    }
  } else {
    // no session in cookie's
    return false;
  }
}

?>
