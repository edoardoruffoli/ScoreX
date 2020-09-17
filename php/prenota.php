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
   		<meta http-equiv = "Refresh" content = "60">

		<!-- CSS -->
		<link rel="shortcut icon" type="image/png" href="../css/images/favicon.ico" />	
		<link rel="stylesheet" type="text/css" href="../css/prenota.css">
		<link rel="stylesheet" type="text/css" href="../css/pageLayout.css">
		<link rel="stylesheet" type="text/css" href="../css/nav.css">
		
		<!-- JavaScript -->
		<script type="text/javascript" src="../js/effects.js"></script>
		<script type="text/javascript" src="../js/scorex.js"></script>
		
		<title>ScoreX, prenota il tuo campo di calcio a 5</title>
  	</head>
  	<body onLoad="beginPrenota()">  		
	  	<header>
		  	<img id="logo" src="../css/images/logo.png">
		</header>	

		<?php
			include "./layout/nav.php";
		?>

		<script type="text/javascript">
			document.getElementById("nbePrenota").setAttribute("class", "navigationBarElement active");
		</script>	

		<form autocomplete="off" name="search" action="./search.php" method="get">
			<div class="autocomplete">
				<button id="searchButton" type="submit"></button>
				<input id="searchField" type="text" name="citta" placeholder="Citta..">	
			</div>
		</form>	

		<?php 
			require "./util/fieldsManagerDb.php"; 
			$listaCitta = array();
			$result = getCityList();

			while(($row =  mysqli_fetch_assoc($result))) {
				$listaCitta[] = $row['citta'];
			}
		?>

		<script>
			var listaCitta = <?php echo json_encode($listaCitta); ?>;
			autocomplete(document.getElementById("searchField"), listaCitta);
		</script>

		<div id="adContainer">
			<div class="counter" id="counterLeft">
				<h1 id="countfields">
					<?php 
						$countFields = count1("field");
						echo $countFields;
					?></h1>
				<h2 class="adquote"> campi disponibili</h2>			
				<script>animateValue("countfields", <?php echo floor($countFields/10) . ', ' .  $countFields?>, 5000);</script>
			</div> 
			<div class="counter">
				<h1 id="countusers">
				<?php 
					$countUsers = count1("user");
					echo $countUsers;
					?>
				</h1> 
				<h2 class="adquote">utenti registrati</h2>
				<script>animateValue("countusers", <?php echo floor($countUsers/10) . ', ' . $countUsers ?>, 5000);</script>
			</div> 
			<div class="counter">
				<h1 id="countbookings">
					<?php 
						$countBookings = count1("prenotazione");
						echo $countBookings;
					?> 
				</h1>
				<script>animateValue("countbookings", <?php echo floor($countBookings/10) . ', ' . $countBookings ?>, 5000);</script>
				<h2 class="adquote"> prenotazioni effettuate </h2>
			</div> 
		</div>

		<?php
			include "./layout/footer.php";
		?>
	</body>
</html>