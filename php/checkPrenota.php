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

    $errorMessage = checkPrenota($userId, $fieldId, $dataP, $dalle, $alle);
    if(!$errorMessage)
        header('location: ./home.php?text=Grazie per la tua prenotazione! :)');
    else {
        if($errorMessage === "Campo già prenotato nell'orario indicato")
            $suggestions = getSuggestions($fieldId, $dataP, $dalle, $alle); //ritorna un array di possibili orari
        header('location: ./detailedField.php?fieldId='. $fieldId . '&errorMessage='. $errorMessage . '&suggestions='. $suggestions );
    }
        
function checkPrenota($userId, $fieldId, $dataP, $dalle, $alle){
    global $ScoreXDb;
    $userId = $ScoreXDb->sqlInjectionFilter($userId);
    $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
    $dataP = $ScoreXDb->sqlInjectionFilter($dataP);
    $dalle = $ScoreXDb->sqlInjectionFilter($dalle);
    $alle = $ScoreXDb->sqlInjectionFilter($alle);

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
                    AND F.from <= '. $dalle . ' AND F.to >= '. $alle;

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

    //controllo spam: 
    //controllo se lo stesso utente ha già effettuato una prenotazione allo stesso orario 
    $queryText = 'SELECT * FROM prenotazione WHERE userId=' . $userId . ' AND dataP= \'' . $dataP . '\' AND dalle=' . $dalle;
    $result = $ScoreXDb->performQuery($queryText);
    $prenotazione = mysqli_fetch_assoc($result);

    if($prenotazione){
        return "Hai già una prenotazione per questo orario";
    }

    //Un utente non può effettuare più di 3 prenotazioni per quel giorno 
    $queryText = 'SELECT count(*) as num FROM prenotazione WHERE dataP = current_date() AND userId = '. $userId ;
    $result = $ScoreXDb->performQuery($queryText);
    $count = $result->fetch_assoc(); 
    if($count['num'] > 3){
        return "Hai già effettuato troppe prenotazioni oggi";
    }
    
    //ricavo il numero di telefono dell'utente, mi servirà avere il numero di telefono nei record di prenotazione, per
    //far si che un proprietario possa aggiungere il numero di telefono a cui riferirsi per prenotazioni esterne al campo
    $telefono = getPhoneByUserId($userId);

    //inserimento della prenotazione 
    $nCicli = $alle - $dalle;
    $alle = $dalle + 1;

    for($x=0; $x < $nCicli; $x++){      //le prenotazione su piu ore sono divise in più prenotazioni su un ora
        $query = 'INSERT INTO prenotazione VALUES(NULL, \'' . $userId . '\', \'' . $fieldId . '\', \'' . $dataP . '\', 
            \'' . $dalle . '\', \'' . $alle . '\', \'' . $telefono . '\') ';
        $ScoreXDb->performQuery($query);
        $dalle++;
        $alle++;
    }
    return null;
}

function getSuggestions($fieldId, $dataP, $dalle, $alle){
    global $ScoreXDb;
    $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
    $dataP = $ScoreXDb->sqlInjectionFilter($dataP);
    $dalle = $ScoreXDb->sqlInjectionFilter($dalle);
    $alle = $ScoreXDb->sqlInjectionFilter($alle);

    $queryText = 'SELECT * FROM Prenotazione WHERE fieldId = ' . $fieldId . ' AND dataP = \'' . $dataP . '\'';

    $result = $ScoreXDb->performQuery($queryText);

    $orariPrenotazione = array();       //array di orari in cui il campo è occupato
    while($row = $result->fetch_assoc()){
        $orariPrenotazione[] = $row['dalle'];
    }

    //trovo gli orari di apertura e chiusura del campo nel giorno richiesto
    //trovo il nome del giorno della prenotazione
    $unixTimestamp = strtotime($dataP);
    $dayOfWeek = date("l", $unixTimestamp);

    //trovo orario di apertura e chiusura in quel giorno
    $queryText = 'SELECT * FROM field_schedule F WHERE F.fieldId = \'' . $fieldId . '\' AND ' . $dayOfWeek . ' = 1';
    $result = $ScoreXDb->performQuery($queryText);
    $numFields = mysqli_num_rows($result);
    if($numFields != 1) { 
        return "Errore: non sono disponibili orari di prenotazione per il campo selezionato";
    }
    $row = $result->fetch_assoc();

    $from = $row['from'];
    $to = $row['to'];

    //trovo orari in cui il campo è libero nel giorno selezionato
    $suggestions = array();
    for($x = max($from, date("H")); $x < $to; $x++){     //current hour, per evitare di suggerire orari nel passato  
        if(!in_array($x, $orariPrenotazione))
            $suggestions[] = $x;
    }
    if(!$suggestions){
        return "Campo non disponibile in nessun orario oggi :(";
    }
    $suggestions = implode(", ", $suggestions);  //Array to string conversion
    return "Campo disponibile nei seguenti orari: " . $suggestions;      
}