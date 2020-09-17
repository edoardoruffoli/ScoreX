<?php
  session_start();
  require_once "./util/ScoreXDbManager.php"; //includes Database Class
  require_once "./util/fieldsManagerDb.php";
  require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
  
  if(!isset($_POST['submit']))
    return;
  
  $rating = $_POST['rating'];
  $reviewTitle = $_POST['reviewTitle'];
  $reviewText = $_POST['reviewText'];
  $fieldId = $_GET['fieldId'];
  $idPrenotazione = $_GET['idPrenotazione'];
  $userId = $_SESSION['userId'];

  $errorMessage = insertReview($userId, $fieldId, $idPrenotazione, $rating, $reviewTitle, $reviewText);
    header('location: ./history.php?text=Grazie per la tua recensione!');

function insertReview($userId, $fieldId, $idPrenotazione, $rating, $reviewTitle, $reviewText){
    global $ScoreXDb;
    
    $userId = $ScoreXDb->sqlInjectionFilter($userId);
    $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
    $idPrenotazione = $ScoreXDb->sqlInjectionFilter($idPrenotazione);
    $rating = $ScoreXDb->sqlInjectionFilter($rating);
    $reviewTitle = $ScoreXDb->sqlInjectionFilter($reviewTitle);
    $userId = $ScoreXDb->sqlInjectionFilter($userId);

    $queryText = 'INSERT review VALUES(NULL, \'' . $userId . '\', \'' . $fieldId . '\',\'' . $idPrenotazione . '\', \'' . $rating . '\', current_date(), \'' . $reviewTitle . '\',\'' . $reviewText . '\')';
    $result = $ScoreXDb->performQuery($queryText);

    $ScoreXDb->closeConnection();
 }

