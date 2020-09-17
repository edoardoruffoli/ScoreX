<?php
  session_start();
  require_once "./util/ScoreXDbManager.php"; //includes Database Class
  require_once "./util/fieldsManagerDb.php";
  require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
  
  $fieldId = $_GET['fieldId'];
  $userId = $_SESSION['userId'];
  $favorite = $_POST['favorite'];
  $favoriteFlag = 1 - $favorite;
  echo $fieldId . '        ';
  echo $userId . '      ';
  echo $favoriteFlag;

  $result = updateFavoriteUserFieldStat($userId, $fieldId, $favoriteFlag);
  if(!empty($result))
     insertFavoriteUserFieldStat($userId, $fieldId, $favoriteFlag);
  header('location: ./detailedfield.php?fieldId='. $fieldId .'');

