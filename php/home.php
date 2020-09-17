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
   		<meta http-equiv = "Refresh" content = "100000">

		<!-- CSS -->
		<link rel="shortcut icon" type="image/png" href="../css/images/favicon.ico" />	
		<link rel="stylesheet" type="text/css" href="../css/home.css">
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
			document.getElementById("nbeHome").setAttribute("class", "navigationBarElement active");
		</script>	

		<section id="ad_section"> 
			<strong id="ad_title">PRENOTA SUBITO IL TUO CAMPO DA CALCETTO</strong>
		
		<!-- VELOCE GRATUITO FACILE -->
			<div class="ad_box">
				<div class="ad_img rocket_img"></div>
				<h2 class="ad_header">VELOCE</h2>
				<p class="ad_parag">Trova rapidamente un campo disponibile nella tua zona e prenota con un clic.</p>

			</div>
			<div class="ad_box">
				<div class="ad_img smile_img"></div>
				<h2 class="ad_header">GRATUITO</h2>
				<p class="ad_parag">Nessun costo aggiuntivo. Inoltre più prenoti più risparmi grazie ai nostri bonus fedeltà.</p>
			</div>

			<div class="ad_box">
				<div class="ad_img nocall_img"></div>
				<h2 class="ad_header">FACILE</h2>
				<p class="ad_parag">Basta telefonate ai centri della tua zona, effettua una ricerca e trova il campo migliore per te.</p>
			</div>
		</section>

		<?php
			echo '<div id="PopUpModal" class="modal">';
			echo '<div class="modal-content">';
			echo '<span class="close" onClick="closePopUp()">&times;</span>';
			echo '<p id="errorText"></p>';
			echo '</div></div>';
		
			if (isset($_GET['text'])){				
				echo '<script> openPopUp();'; 
				echo 'document.getElementById("errorText").textContent = "' . $_GET['text'] .'";';
				echo '</script>';
			}		
			echo '</div>';
			include "./layout/footer.php";
		?>
	</body>
</html>