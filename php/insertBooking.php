<?php
    session_start(); //Per trovare userId
    require_once "./util/ScoreXDbManager.php"; //includes Database Class
    require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
    require_once "./layout/fields_dashboard.php";

    global $fieldRow;               

    $fieldId = $_GET['fieldId'];
    $userId = $_SESSION['userId']; 
    $dataP = $_POST['data'];
    $dalle = $_POST['dalle'];
    $alle = $_POST['alle'];
    $telefono = $_POST['telefono'];

    echo $telefono;

    $errorMessage = checkPrenota($userId, $fieldId, $dataP, $dalle, $alle, $telefono);
    if($errorMessage === null)
        header('location: ./myField.php');
    else {
        header('location: ./myField.php?errorMessage='. $errorMessage);
    }
        
function checkPrenota($userId, $fieldId, $dataP, $dalle, $alle, $telefono){
    global $ScoreXDb;
    $userId = $ScoreXDb->sqlInjectionFilter($userId);
    $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
    $dataP = $ScoreXDb->sqlInjectionFilter($dataP);
    $dalle = $ScoreXDb->sqlInjectionFilter($dalle);
    $alle = $ScoreXDb->sqlInjectionFilter($alle);
    $telefono = $ScoreXDb->sqlInjectionFilter($telefono);

    //controllo che l'orario non sia nel passato
    $currentDate = date("Y-m-d");
    $currentHour = date("H");

    if($currentDate == $dataP && $currentHour > $dalle)
        return "Errore: Orario non valido";

    //controllo se il campo è aperto a quell ora
    //trovo gli orari di apertura e chiusura del campo nel giorno richiesto
    //trovo il nome del giorno della prenotazione
    $unixTimestamp = strtotime($dataP);
    $dayOfWeek = date("l", $unixTimestamp);

    //trovo orario di apertura e chiusura in quel giorno
    $queryText = 'SELECT * FROM field_schedule F WHERE F.fieldId = \'' . $fieldId . '\' AND ' . $dayOfWeek . ' = 1 
                    AND F.from <= ' . $dalle . ' AND F.to >= '. $alle;

    $result = $ScoreXDb->performQuery($queryText);
    $numFields = mysqli_num_rows($result);
    if($numFields != 1) { 
        return "Errore: il campo è chiuso nell'orario indicato";
    }

    //controllo se ci sono già prenotaioni in quell orario
    for($x = $dalle; $x < $alle; $x++){     //ciclo for per prenotazioni che occupano più di un'ora
        $queryText = 'SELECT * FROM prenotazione WHERE fieldId = \'' . $fieldId . '\' AND dataP = \'' . $dataP . '\'
                        AND dalle = ' . $x;
        $result = $ScoreXDb->performQuery($queryText);
        $numBookings = mysqli_num_rows($result);

        if($numBookings != 0){
            return "Campo già prenotato nell'orario indicato";
        }
    }

    //inserimento della prenotazione 
    $nCicli = $alle - $dalle;
    $alle = $dalle + 1;

    for($x=0; $x < $nCicli; $x++){      //le prenotazione su piu ore vengono divise in più prenotazioni di un'ora
        $query = 'INSERT INTO prenotazione VALUES(NULL, \'' . $userId . '\', \'' . $fieldId . '\', \'' . $dataP . '\', 
                                                 \'' . $dalle . '\', \'' . $alle . '\', \'' . $telefono . '\') ';
        $ScoreXDb->performQuery($query);
        $dalle++;
        $alle++;
    }
    return null;
}
