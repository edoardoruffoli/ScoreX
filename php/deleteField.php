<?php
    session_start();
    require_once "./util/ScoreXDbManager.php"; //includes Database Class
    
    $fieldId = $_POST['fieldId'];
    $filename = $_POST['img'];

    deleteField($fieldId, $filename);
    header('location: ./myField.php');

    function deleteField($fieldId, $filename){
        global $ScoreXDb;
        $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);

        $queryText = 'DELETE FROM field_schedule WHERE fieldId = \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);

        $queryText = 'DELETE FROM my_field WHERE fieldId = \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);

        $queryText = 'DELETE FROM user_field WHERE fieldId = \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);

        $queryText = 'DELETE FROM prenotazione WHERE fieldId = \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);

        $queryText = 'DELETE FROM review WHERE fieldId = \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);
        
        $queryText = 'DELETE FROM field WHERE fieldId = \'' . $fieldId . '\'';
        $result = $ScoreXDb->performQuery($queryText);
        
        $ScoreXDb->closeConnection();

        //Rimuovo immagine campo dalla cartella 
        if (file_exists($filename)) {
            unlink($filename);
            echo 'File '.$filename.' has been deleted';
        }else {
            echo 'Could not delete '. $filename .', file does not exist';
        }
        
        return null;
    }
?>