<?php
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
		<meta name= "viewport" content="width=device-width, initial-scale=1.0"> <!-- Si vede meglio su device -->
   		<!--<meta http-equiv = "Refresh" content = "60"> -->

		<!-- CSS -->
		<link rel="shortcut icon" type="image/png" href="../css/images/favicon.ico" />	
		<link rel="stylesheet" type="text/css" href="../css/detailedField.css">
		<link rel="stylesheet" type="text/css" href="../css/pageLayout.css">
		<link rel="stylesheet" type="text/css" href="../css/nav.css">
		
		<!-- JavaScript -->
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/scorex.js"></script>
		<script type="text/javascript" src="../js/ajax/ajaxManager.js"></script>	
		<script type="text/javascript" src="../js/ajax/reviewLoader.js"></script>
		<script type="text/javascript" src="../js/ajax/reviewsDashboard.js"></script>
		<script type="text/javascript" src="../js/ajax/userFieldEventHandler.js"></script>
		
		<title>ScoreX, prenota il tuo campo di calcio a 5</title>
	</head>
	<body>
        <header>
		  	<img id="logo" src="../css/images/logo.png" alt="logo">
		</header>

		<?php
			include "./layout/nav.php";
		?>

		<script type="text/javascript">
			document.getElementById("nbePrenota").setAttribute("class", "navigationBarElement active");
		</script>	
		
		<?php
			include "./util/fieldsManagerDb.php";	
			include "./layout/fields_dashboard.php";

			echo '<div id="content">';
			$fieldId = $_GET['fieldId'];
			$result = getFieldById($fieldId);	
			showDetailedField($result);	
			echo '</div>';
		?>				

		<?php
			include "./layout/footer.php";
		?>

	</body>
</html>