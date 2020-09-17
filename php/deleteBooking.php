<?php
    require_once "./util/ScoreXDbManager.php"; //includes Database Class
    
    $idPrenotazione = $_GET['id'];

    $errorMessage = deleteBooking($idPrenotazione);
    if($errorMessage === null)
        header('location: ./myField.php');
    else {
        header('location: ./myField.php?errorMessage='. $errorMessage);
    }

    function deleteBooking($idPrenotazione){
        global $ScoreXDb;
        $idPrenotazione = $ScoreXDb->sqlInjectionFilter($idPrenotazione);

        $queryText = 'DELETE FROM prenotazione WHERE idPrenotazione = ' . $idPrenotazione;
        $result = $ScoreXDb->performQuery($queryText);
        $ScoreXDb->closeConnection();
        return null;
    }
?>