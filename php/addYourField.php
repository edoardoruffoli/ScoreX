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
		  	<img id="logo" src="../css/images/logo.png" alt="logo">
		</header>

		<?php
			include "./layout/nav.php";
		?>
	
        <script type="text/javascript">
			document.getElementById("addYourFieldTag").setAttribute("class", "active");
		</script>	

		<?php
			include "./layout/fields_dashboard.php";
			showAddYourFieldForm();
		?>

		<?php
			include "./layout/footer.php";
		?>
	</body>
</html>

