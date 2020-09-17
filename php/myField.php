<?php
	require_once "./config.php";
	session_start();
	
    include "./util/sessionUtil.php";

    if (!isLogged() || $_SESSION['userType'] != 'socio'){
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
   		<meta http-equiv = "Refresh" content = "60">

		<!-- CSS -->
		<link rel="shortcut icon" type="image/png" href="../css/images/favicon.ico" />	
		<link rel="stylesheet" type="text/css" href="../css/myField.css">
		<link rel="stylesheet" type="text/css" href="../css/pageLayout.css">
		<link rel="stylesheet" type="text/css" href="../css/nav.css">
		
		<!-- JavaScript -->
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/scorex.js"></script>

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
			document.getElementById("myFieldTag").setAttribute("class", "active");
		</script>	

		<?php
			//INSERISCI ORARI
			include "./layout/my_field.php";
			$userId = $_SESSION['userId'];
			$result = getMyFieldInfo($userId);
			showMyField($result);
		?>

		<?php
			include "./layout/footer.php";
		?>
	</body>
</html>