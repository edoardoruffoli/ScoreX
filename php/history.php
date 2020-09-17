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
	<body>
	  	<header>
			<img id="logo" src="../css/images/logo.png" alt="logo">
        </header>

		<?php
			include "./layout/nav.php";
		?>

        <script type="text/javascript">
			document.getElementById("historyTag").setAttribute("class", "active");
		</script>	

		<h2 class="header_over_results">Prenotazioni &#9917</h2>
		<h2 id="ReviewsAd" class="header_over_results Reviews">Recensioni &#9997</h2>
        <?php
            include "./layout/fields_dashboard.php";
			$userId = $_SESSION['userId'];
            $result = getBookingsByUserId($userId);
			showBookings($result);
			
			$result = getReviewsByUserId($userId);
			showReviews($result);

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