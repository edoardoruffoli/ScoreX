<?php
  session_start();
  require_once "./util/ScoreXDbManager.php"; //includes Database Class
  require_once "./util/fieldsManagerDb.php";
  require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
  
  $userId = $_SESSION['userId'];
  $_SESSION['userType'] = 'socio';

   upgradeUser($userId);
   header('location: ./home.php?text=Adesso sei diventato socio ScoreX!');

function upgradeUser($userId){
    global $ScoreXDb;
    
    $userId = $ScoreXDb->sqlInjectionFilter($userId);

    $queryText = 'UPDATE user SET userType = "socio" WHERE userId = \'' . $userId . '\'';
    $result = $ScoreXDb->performQuery($queryText);

    $ScoreXDb->closeConnection();
    return;
 }

