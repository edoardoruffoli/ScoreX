<?php
	session_start();
    include "./php/util/sessionUtil.php";

    if (isLogged()){
		    header('Location: ./php/home.php');
		    exit;
    }	
?>
<!DOCTYPE html>
<html lang="it">
<head>
		<meta charset="utf-8"> 
    	<meta name = "service" content = "Prenotazione campi di calcetto">
    	<meta name = "keywords" content = "calcetto, prenotazione, campi, calcio">
   		<meta http-equiv = "Refresh" content = "300000">
		<title>ScoreX, prenota il tuo campo di calcio a 5</title>

		<link rel="shortcut icon" type="image/png" href="./css/images/favicon.ico" />
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="./css/index.css">
		<link rel="stylesheet" type="text/css" href="./css/pageLayout.css">

		<!-- JavaScript -->
		<script type="text/javascript" src="./js/effects.js"></script>
		<script type="text/javascript" src="./js/scorex.js"></script>
		
  	</head>
	<body onLoad="beginIndex()"> 

		<header><img id="logo" src="./css/images/logo.png"></header>
		
		<section id="sign_in_content">

			<div id="loginbutton">
				<button onclick="openForm('login_form')">Accedi</button>
			</div>

			<div id="login_form" class="modal">

				<form class="modal-content animate" name="login" action="./php/login.php" method="post" onSubmit="return validateLoginForm()">

					<div class="imgcontainer">
						<span onclick="closeForm('login_form')" class="close">&times;</span>
						<img src="./css/images/profile.png" alt="Avatar" class="avatar">
					</div>

					<div class="container">
						<label><b>Username</b></label>
						<input type="text" placeholder="Username" name="username" required autofocus>
					
						<label><b>Password</b></label>
						<input type="password" placeholder="Password" name="password" required>

						<button type="submit">Accedi</button>
					</div>
				</form>					

			</div>				

		</section>

		<section id="register_content">
			<div id="registerbutton">
				<button onclick="openForm('register_form')">Registrati</button>
			</div>

			<div id="register_form" class="modal">
				<form class="modal-content animate" name="registerForm" action="./php/register.php" method="post" onSubmit="return validateRegisterForm()">

				<div class="imgcontainer">
					<span onclick="closeForm('register_form')" class="close">&times;</span>
   					<img src="./css/images/profile.png" alt="Avatar" class="avatar">
				</div>

				<div class="container">
					<label><b>Username</b></label>
					<input type="text" placeholder="Username" name="username" required autofocus>

					<label><b>Email</b></label>
					<input type="text" placeholder="Email" name="email" required autofocus>

					<label><b>Telefono</b></label>
					<input type="text" placeholder="Telefono" name="telefono" required autofocus>
				
					<label><b>Password</b></label>
					<input type="password" placeholder="Password" name="password" required>

					<label><b>Confirm Password</b></label>
					<input type="password" placeholder="Confirm Password" name="confirmPassword" required>

					<button type="submit" name="submit">Registrati</button>
				</form>
			</div>

		</section>
				<?php
						if (isset($_GET['errorMessage'])){
							echo '<div class="sign_in_error">';
							echo $_GET['errorMessage']  ;
							echo '</div>';
						}
					?>

		<?php
			include "./php/layout/footer.php";
		?>			
	</body>
</html>