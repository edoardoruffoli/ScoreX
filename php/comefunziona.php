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
   		<meta http-equiv = "Refresh" content = "100">

		<!-- CSS -->
		<link rel="shortcut icon" type="image/png" href="../css/images/favicon.ico" />	
		<link rel="stylesheet" type="text/css" href="../css/comeFunziona.css">
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
			document.getElementById("nbeComeFunziona").setAttribute("class", "navigationBarElement active");
		</script>	

		
	<section class="content">
			<div class="left"> 
				<div class="img-content">	
					<img src="../css/images/glass.png" alt="magnfying_glass">
				</div>
				<div class="text-content">				
					<h1>CERCA UN CAMPO LIBERO VICINO A TE</h1>
					<p>Clicca sulla voce <i>Prenota</i>, inserisci la tua città e scegli il campo che preferisci.</p>
				</div>
			</div>

			<div class="right"> 
				<div class="text-content">
					<h1>PRENOTA E PAGA DIRETTAMENTE AL CAMPO</h1>
					<p>Nessun costo aggiuntivo e soprattutto basta chiamate.</p>
				</div>
				<div class="img-content">	
					<img src="../css/images/phone.png" alt="phone">
				</div>

			</div>

			<div class="left"> 
				<div class="img-content">	
					<img src=../css/images/pencil.png alt="pencil">
				</div>
				<div class="text-content">				
					<h1>VALUTA LA TUA ESPERIENZA</h1>
					<p>Cliccando sulla voce <i>Cronologia</i> del menu a scorrimento potrai lasciare una valutazione per aiutare gli altri utenti a scegliere i campi migliori.</p>
				</div>
			</div>

			
			<div class="right"> 
				<div class="text-content">
					<h1>SALVA I TUOI CAMPI PREFERITI</h1>
					<p>Clicca sull'icona a forma di cuore per aggiungere un campo ai preferiti.</p>
				</div>
				<div class="img-content">	
					<img src=../css/images/favorites1.png alt="love"> 
				</div>
			</div>

			<div class="left"> 
				<div class="img-content">	
					<img src="../css/images/promo_demo.gif" alt="promo">
				</div>
				<div class="text-content">				
					<h1>GESTISCI UN CENTRO SPORTIVO?</h1>
					<p>Usi ancora carta e penna per gestire le tue prenotazioni? La tua visibilità su Internet è scarsa? Registra subito il tuo campo su ScoreX.</p>
					<button onclick="location.href = './addYourField.php'"><b>Scopri di più</b></button>
				</div>
			</div>

		</section>
		
		<?php
			include "./layout/footer.php";
		?>
	</body>
</html>