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
		<meta name= "viewport" content="width=device-width, initial-scale=1.0"> <!-- Si vede meglio su device -->
   		<meta http-equiv = "Refresh" content = "60">

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
		<?php
			require_once "./util/fieldsManagerDb.php";
			$citta = $_GET['citta'];
			
			$citta = strtolower($citta);
			//metto maiuscola la prima lettera di città
			$citta = ucwords($citta);
			$totResults = totFieldsByCitta($citta);
			
		?>

		<body onload='FieldLoader.loadDataByCitta(<?php print json_encode($citta); ?>)'
			  onscroll='FieldLoader.loadMoreByCitta(<?php print json_encode($citta); ?>)'> <!-- ci sono stato problemi con "" -->
	  	<header>
		  	<img id="logo" src="../css/images/logo.png" alt="logo">
		</header>

		<?php
			include "./layout/nav.php";
		?>
		
		<script type="text/javascript">
			document.getElementById("nbePrenota").setAttribute("class", "navigationBarElement active");
		</script>	

		<!-- //AJAX AGGIORNAMENTO RISULTATI IN BASE AL NOME CAMPO	-->
		<h1 class="header_over_results"><?php echo $totResults . ' <small>campi trovati a </small>' . $citta ;?></h1>

		<div id="searchBox">
		<input id="searchByPattern" type="text" placeholder="Nome del campo" 
			onkeyup='FieldLoader.loadDataByCittaAndPattern(this.value ,<?php print json_encode($citta); ?>)'>
		</div>

		<!--<button>&#9776;</button>-->
		<div class="sort">Ordina Per
			<select id="sortBy" onchange='FieldLoader.loadDataByCitta(<?php print json_encode($citta);?>)'>
				<option value="Default">Rilevanza</option>
				<option value='RatingDESC'>Rating DESC</option>
				<option value='RatingASC'>Rating ASC</option>
			</select>
		</div>
		<section id="FieldDashboard"></section><!-- Fill dinamically with Ajax Request -->

		<?php
			include "./layout/footer.php";
		?>
	</body>
</html>


