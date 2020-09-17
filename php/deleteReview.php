<?php
    require_once "./util/ScoreXDbManager.php"; //includes Database Class
    
    $idReview = $_GET['id'];

    $errorMessage = deleteReview($idReview);
    header('location: ./history.php');

    function deleteReview($idReview){
        global $ScoreXDb;
        $idReview = $ScoreXDb->sqlInjectionFilter($idReview);

        $queryText = 'DELETE FROM review WHERE idReview = ' . $idReview;
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return null;
    }
?>