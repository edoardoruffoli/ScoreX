<?php
  session_start();
  require_once "./util/ScoreXDbManager.php"; //includes Database Class
  require_once "./util/fieldsManagerDb.php";
  require_once "./util/sessionUtil.php"; //includes sessinUtil.php"; //includes session login
  
  if(!isset($_POST['submit']))
    return;
  
  $nome = $_POST['nome'];
  $descrizione = $_POST['descrizione'];
  $citta = $_POST['citta'];
  $cap = $_POST['cap'];
  $indirizzo = $_POST['indirizzo'];
  $telefono = $_POST['telefono'];
  
  $orari = array();           //costruisco array orari
  for($x=0; $x<7; $x++){
      $dalle = ($_POST['dalle'.$x] != null) ? $_POST['dalle'.$x]:0;
      $alle  = ($_POST['alle'.$x] != null) ? $_POST['alle'.$x]:0;
      $orari[] = array($dalle, $alle);
  }

  $fieldId = getNewFieldId();   //devo ottenerlo prima di fare la query di inserimento per rinominare l'img

  //Faccio i controlli prima di caricare l'immagine
  if($_FILES['img']['size']>0){
      echo 'Cè un file caricato';
      
      $_FILES['img']['name'] = "campo" . $fieldId .".jpg";
      $uploaddir = '../css/images/fields/';
      $uploadfile = $uploaddir . $_FILES['img']['name'];

      //INFO UPLOAD FILE CODICE COPIATO
      echo "<p>";

      if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
      } else {
        echo "Upload failed";
      }

      //COPIATO
      echo "</p>";
      echo '<pre>';
      echo 'Here is some more debugging info:';
      print_r($_FILES);
      print "</pre>";
  }
  else{
    echo 'non cè un file caricato';
    $uploadfile = '../css/images/fields/noposter.png';
  }

  insertField($fieldId, $nome, $citta, $indirizzo, $cap, $descrizione, $telefono, $uploadfile);
  insertSchedule($fieldId, $orari);
  header('location: ./myField.php');


function insertField($fieldId, $nome, $citta, $indirizzo, $cap, $descrizione, $telefono, $uploadfile){
    global $ScoreXDb;
    
    $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);
    $nome = $ScoreXDb->sqlInjectionFilter($nome);
	  $citta = $ScoreXDb->sqlInjectionFilter($citta);
    $indirizzo = $ScoreXDb->sqlInjectionFilter($indirizzo);
    $cap = $ScoreXDb->sqlInjectionFilter($cap);
    $descrizione = $ScoreXDb->sqlInjectionFilter($descrizione);
    $telefono = $ScoreXDb->sqlInjectionFilter($telefono);
    $uploadfile = $ScoreXDb->sqlInjectionFilter($uploadfile);

    $citta = ucfirst($citta);   //metto la prima lettera maiuscola 
    $indirizzo = ucwords($indirizzo);   //metto tutte le iniziali maiuscole 

    $queryText = 'INSERT field VALUES(\'' . $fieldId . '\', \'' . $nome . '\', \'' . $descrizione . '\',\'' . $uploadfile . '\',\'' . $indirizzo . '\',\'' . $cap . '\',\'' . $citta . '\',\'' . $telefono . '\')';
    $result = $ScoreXDb->performQuery($queryText);

    $userId = $_SESSION['userId'];
    $queryText = 'INSERT my_field VALUES(NULL, \'' . $userId . '\', \'' . $fieldId . '\')';
    $result = $ScoreXDb->performQuery($queryText);

    $ScoreXDb->closeConnection();
    return null;
 }

function insertSchedule($fieldId, $orari){
    global $ScoreXDb;
    $fieldId = $ScoreXDb->sqlInjectionFilter($fieldId);

    for($x=0; $x < 7; $x++){
        if(empty($orari[$x]))    //CONTROLLO SE IL GIORNO IN QUESTIONE è GIA STATO GESTITO
         continue;

        $queryText = 'INSERT field_schedule VALUES(NULL, ' . $fieldId .', ';

        $giorniStessoOrario = array(); //se ci sono giorni con orari coincidenti, semplifico
        //inizializzo a 0
        for($k=0; $k < 7; $k++)
          $giorniStessoOrario[$k] = 0;
       
        for($y=$x+1; $y < 7; $y++){
            if(empty($orari[$x]) || empty($orari[$y]))    //possono essere stati eliminati 
                continue;
            if($orari[$x][0] == $orari[$y][0] && $orari[$x][1] == $orari[$y][1]){   //SE DUE GIORNI HANNO LO STESSO ORARIO
                
                //RIMUOVO DALL ARRAY ORARI  
                unset($orari[$y]);
                $giorniStessoOrario[$y] = 1;   //salvo il giorno rimosso (l'indice è il giorno, vale 1 se è uguale)  
            }
        } 

        for($k=$x; $k > 0; $k-- )   //metto 0 nella query ai giorni gia gestiti
            $queryText = $queryText .'0, ';

        $queryText = $queryText .'1, ';   //metto 1 al giorno che sto gestendo

        for($k=$x+1; $k < 7; $k++){          //metto 1 ai giorni con lo stesso orario
            if($giorniStessoOrario[$k] == 1)
                $queryText = $queryText .'1, ';
            else $queryText = $queryText .'0, ';
        }

        $queryText = $queryText. $orari[$x][0] . ', ' . $orari[$x][1] .')';      //AGGIUNGO ORARIO ALLA QUERY
          
        //debugging
        echo $queryText;
        echo  nl2br ("\n");

        $result = $ScoreXDb->performQuery($queryText);    //ESEGUO QUERY DI INSERIMENTO
    }

    $ScoreXDb->closeConnection();
    return null;

}

