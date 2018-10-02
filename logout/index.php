<?php
  unset($_COOKIE['id']);
  unset($_COOKIE['SESSION_HASH']);
  setcookie('id', null, -1, '/');
  setcookie('SESSION_HASH', null, -1, '/');
  header("Location: https://scheduler-wob.000webhostapp.com/login/");
?>