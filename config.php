<?php
  //header("Content-Type: text/html; charset=utf-8");

  $con = mysqli_connect("localhost", "type-id-here", "type-pass-here");
  mysqli_select_db($con, "nova");

  mysqli_query($con, "SET NAMES utf8");
?>