<?php
	require_once "./config.php";
	session_start();
	
    include "./util/sessionUtil.php";

    if (!isLogged()){
		    header('Location: ./../index.php');
		    exit;
    }	
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"> 
    	<meta name = "service" content = "Prenotazione campi di calcetto">
    	<meta name = "keywords" content = "calcetto, prenotazione, campi, calcio">
		
		<!-- CSS -->
		<link rel="shortcut icon" type="image/png" href="../css/images/favicon.ico" />	
		<link rel="stylesheet" type="text/css" href="../css/prenota.css">
		<link rel="stylesheet" type="text/css" href="../css/pageLayout.css">
		<link rel="stylesheet" type="text/css" href="../css/nav.css">
		
		<!-- JavaScript -->
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/scorex.js"></script>
		<script type="text/javascript" src="../js/ajax/ajaxManager.js"></script>	
		<script type="text/javascript" src="../js/ajax/fieldLoader.js"></script>
		<script type="text/javascript" src="../js/ajax/fieldsDashboard.js"></script>
		<script type="text/javascript" src="../js/ajax/userFieldEventHandler.js"></script>

		<title>ScoreX, prenota il tuo campo di calcio a 5</title>
  	</head>

	<body> <!-- ci sono stato problemi con "" -->
	  	<header>
		  	<img id="logo" src="../css/images/logo.png">
		</header>

		<?php
			include "./layout/nav.php";
		?>
	
    <script type="text/javascript">
			document.getElementById("myFieldTag").setAttribute("class", "active");
	</script>	

		<?php
			include "./layout/fields_dashboard.php";
			showAddYourFieldForm();
		?>

    <script>
	  var fieldId = '<?php echo $_POST['fieldId'] ?>';
      var oldName = '<?php echo $_POST['nome'] ?>';
      var oldDes = '<?php echo $_POST['descrizione'] ?>';
	  var oldPhone = '<?php echo $_POST['telefono'] ?>';
	  var urlImg = '<?php echo $_POST['img'] ?>';

      //inserisco i vecchi dati 
      var formDiv = document.getElementById("add_your_field_form");
      formDiv.childNodes[1].childNodes[1].value = oldName;
      formDiv.childNodes[1].childNodes[3].value = oldDes;
      formDiv.childNodes[1].childNodes[6].childNodes[3].value = oldPhone;

      //trasformo la pagina insertField in updateField  
      document.getElementById("scheduleTag").textContent = "Inserisci Nuovo Orario";
      document.getElementById("submitBtn").textContent = "Aggiorna Dati";
      formDiv.childNodes[0].textContent = "Modifica Informazioni";
      formDiv.childNodes[1].setAttribute("action", "updateYourField.php?fieldId=" + fieldId);      
      formDiv.childNodes[1].setAttribute("onSubmit", "return checkSchedule()");    
      formDiv.childNodes[1].childNodes[6].childNodes[1].remove();    
      formDiv.childNodes[1].childNodes[6].childNodes[0].remove();    
      formDiv.childNodes[1].removeChild(formDiv.childNodes[1].childNodes[5]);
	  formDiv.childNodes[1].childNodes[5].setAttribute("class", "input_box"); //sposto a sinistra telefono (tolgo classe right)
	 
	  //aggiungo bottone rimuovi campo
	  var form = document.createElement("form");
	  form.setAttribute("action", "deleteField.php");
	  form.setAttribute("onSubmit", "return confirm('Sei Sicuro?')");
	  form.setAttribute("method", "post");
	  var input1 = document.createElement("input");
	  input1.setAttribute("type", "hidden");
	  input1.setAttribute("value", fieldId);
	  input1.setAttribute("name", "fieldId");
	  var input2 = document.createElement("input");
	  input2.setAttribute("type", "hidden");
	  input2.setAttribute("value", urlImg);
	  input2.setAttribute("name", "img");
	  var button = document.createElement("button");
	  button.textContent = "Rimuovi Campo";
	  button.setAttribute("class", "warning");
	  button.setAttribute("type", "submit");
	  form.appendChild(input1);
	  form.appendChild(input2);
	  form.appendChild(button);
	  formDiv.appendChild(form);
	  
   </script>
    
		<?php
			include "./layout/footer.php";
		?>
	</body>
</html>