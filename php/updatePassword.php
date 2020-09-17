<?php
  session_start();
  require_once "./util/ScoreXDbManager.php"; //includes Database Class
  require_once "./util/fieldsManagerDb.php";
  require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
  
  if(!isset($_POST['submit']))
    return;
  
  $password = $_POST['password'];
  $userId = $_SESSION['userId'];

  updatePassword($userId, $password);
  header('location: ./profile.php?message=Password modificata con successo!');


function updatePassword($userId, $password){
    global $ScoreXDb;
    
    $userId = $ScoreXDb->sqlInjectionFilter($userId);
    $password = $ScoreXDb->sqlInjectionFilter($password);

    $cryptpassword = md5($password);//encrypt the password before saving in the database COPIATO
    
    $queryText = 'UPDATE user SET password = \'' . $cryptpassword . '\' WHERE userId = \'' . $userId . '\'';
    $result = $ScoreXDb->performQuery($queryText);
    $ScoreXDb->closeConnection();
    return null;
 }
