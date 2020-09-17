<?php
    require_once "./util/fieldsManagerDb.php";
    require_once "./util/sessionUtil.php";
    require_once "./util/message_Util.php";

    function showDetailedField($result){
		$numFields = mysqli_num_rows($result);
		if($numFields != 1) { 
			showError();	
			return;
		}
		$fieldRow = $result->fetch_assoc();
		
		//creo un array con gli orari
		$result = getHoursByFieldId($fieldRow['fieldId']);
		$numRows = mysqli_num_rows($result);
		if($numRows == 0) { 
			showError();	
			return;
		}
		$orari = array();
		while($orariRow = $result->fetch_assoc()){
			$orari[] = $orariRow;
		}
		//creo un array con i giorni della settimana in italiano e uno con quelli in inglese
		$giornoSettimana = array("Lunedì","Martedì","Mercoledì","Giovedì","Venerdì","Sabato","Domenica");//da stampare
		$dayOfWeek = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");//per scegliere quale evidenziare

		//controllo se il campo è tra i preferiti dell'utente
		$userId = $_SESSION['userId'];
		$favorite = userIdFieldIdFavorite($userId, $fieldRow['fieldId']);

		//Google Maps
		$string = 'http://maps.google.com/maps?q='. $fieldRow['indirizzo'] . ' ' . $fieldRow['citta'];
		$googleMapsUrl= str_replace(' ', '+', trim($string));
			
		//OUTPUT
		echo '<div id="detailed_field_tab">';				
			echo '<div id="main">';
				echo '<div id="detailed_poster">';
					if($fieldRow['poster'] == "N/A"){
						echo '<img src="../css/images/fields/noposter.png" alt="poster">'; 
					} else {
						echo '<img src="' . $fieldRow['poster'] . '" alt="poster">';
					}
				echo '</div>';
				echo '<div id="main_text">';
					echo '<h1>' . $fieldRow['nome'] . '</h1>';
					echo '<p>' . $fieldRow['descrizione'] . '</p>';
				echo '</div>';
				echo '<div class="favorite_field_item">';
					echo '<form name="updateStatusForm" method="post" action="updateFavorite.php?fieldId='. $fieldRow['fieldId'] . '">';
						if($favorite == 0)
							echo '<div class="favorite_img_0" onClick="update()">';
						else 
							echo '<div class="favorite_img_1" onClick="update()">';
						echo '<input type="hidden" name="favorite" value='. $favorite .'>';
						echo '</div>'; 
					echo '</form>';
				echo '</div>';
			echo '</div>';

			echo '<div id="middle">';
				echo '<div class="content_field_wrapper">';
					echo '<p><span class="field_info">Indirizzo</span>: '  . $fieldRow['indirizzo'] . '</p>';
					echo '<p><span class="field_info">Cap</span>: ' .  $fieldRow['cap'] . '</p>';
					echo '<p><span class="field_info">Citta</span>: ' .  $fieldRow['citta'] . '</p>';
					echo '<p><span class="field_info">Telefono</span>: ' . $fieldRow['telefono'] . '</p>';
					echo '<p><a id="field_info_maps" class="field_info" href="'. $googleMapsUrl .'" target="blank"> Apri su Maps </a></p>';
					echo '<p id="last_field_info"><span class="field_info">Orario:</p>';

					//trovo il nome del giorno corrente
					$today = date("Y-m-d");
					$unixTimestamp = strtotime($today);
					$todayDay = date("l", $unixTimestamp);

					//orari
					echo '<div id="schedule">';
					for($x=0; $x < 7; $x++){
						if($dayOfWeek[$x] == $todayDay)
							echo '<b>';
						echo '<span class="field_hours">'. $giornoSettimana[$x] .'</span>';
						if($dayOfWeek[$x] == $todayDay)
							echo '</b>';

						$y = 0;
						while(!empty($orari[$y])){
							if($orari[$y][$dayOfWeek[$x]] == 1)
								echo '<span class="hours">'. $orari[$y]['from'] . ' - ' . $orari[$y]['to'] .'</span><br>';
							$y++;
						}
					}
					echo '</div>';
				echo '</div>';		

				//RECENSIONI
				echo '<div id= "review_section">';
					echo '<h2 class="heading">User Rating</h2>';

					$rating = getAveragereviewRating($fieldRow['fieldId']);
					$rating = number_format((float)$rating, 1, '.', ''); //arrotondo alla seconda cifra dec
					$starRating = ($rating - floor($rating) >= 0.5)?floor($rating)+1:floor($rating); //parte frazionaria 
					
					//Stelle
					for ($i = 0; $i < $starRating; $i++) {
						echo '<span class="rating_field_star checked"></span>';
					}
					while ($i < 5){
						echo '<span class="rating_field_star"></span>';
						$i++;
					}

					$totalReviews = getTotalReviews($fieldRow['fieldId']);		

					echo '<h3 id="averageNumber"> '. $rating .' </h3>';
					echo '<h4 id="totalNumber" onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 0)"> ' . $totalReviews .' reviews</h4>';

					echo '<div class="row">';

					$totRating5 = getReviewsByRating($fieldRow['fieldId'], 5);
					$totRating4 = getReviewsByRating($fieldRow['fieldId'], 4);
					$totRating3 = getReviewsByRating($fieldRow['fieldId'], 3);
					$totRating2 = getReviewsByRating($fieldRow['fieldId'], 2);
					$totRating1 = getReviewsByRating($fieldRow['fieldId'], 1);

					$totalReviews = ($totalReviews==0)?1:$totalReviews;
					$percBar5 = 100*$totRating5/$totalReviews;
					$percBar4 = 100*$totRating4/$totalReviews;
					$percBar3 = 100*$totRating3/$totalReviews;
					$percBar2 = 100*$totRating2/$totalReviews;
					$percBar1 = 100*$totRating1/$totalReviews;

					//BARRE
					//5 
					echo '<div class="side" onclick="$reviewsSelected = selectReviews(5)"><div>5 star</div></div>';
					echo '<div class="middle"><div class="bar-container"><div class="bar-5" style="width:' . $percBar5 . '%" onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 5)"></div></div></div>';
					echo '<div class="side right"><div onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 5)">' . $totRating5 . '</div></div>';

					//4
					echo '<div class="side"><div>4 star</div></div>';
					echo '<div class="middle"><div class="bar-container"><div class="bar-4" style="width:' . $percBar4 . '%" onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 4)"></div></div></div>';
					echo '<div class="side right"><div onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 4)">' . $totRating4 . '</div></div>';

					//3
					echo '<div class="side"><div>3 star</div></div>';
					echo '<div class="middle"><div class="bar-container"><div class="bar-3" style="width:' . $percBar3 . '%" onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 3)"></div></div></div>';
					echo '<div class="side right"><div onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 3)">' . $totRating3 . '</div></div>';

					//2
					echo '<div class="side"><div>2 star</div></div>';
					echo '<div class="middle"><div class="bar-container"><div class="bar-2" style="width:' . $percBar2 . '%" onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 2)"></div></div></div>';
					echo '<div class="side right"><div onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 2)">' . $totRating2 . '</div></div>';

					//1
					echo '<div class="side"><div>1 star</div></div>';
					echo '<div class="middle"><div class="bar-container"><div class="bar-1" style="width:' . $percBar1 . '%" onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 1)"></div></div></div>';
					echo '<div class="side right"><div onClick="ReviewLoader.loadReviewByRating(' . $fieldRow['fieldId'] .', 1)">' . $totRating1 . '</div></div>';
				echo '</div>';
			echo '</div>';
			
			//FORM PRENOTA
			$month = date('m');
			$day = date('d');
			$year = date('Y');
			$fromHour = date('H');
			$toHour = ($fromHour+1==24)?0:$fromHour+1;
			$today = $year . '-' . $month . '-' . $day ;
				
			echo '<div id="booking_form">';

			echo '<form name="bookingForm" action="checkPrenota.php?fieldId=' . $fieldRow['fieldId'] .'" method="post" onSubmit="return checkPrenotazione()">';
				echo '<label><b>Giorno</b></label>';
				echo '<input type="date" name="data" value=' . $today . ' min=' . $today . ' required><br>';
				echo '<label><b>Dalle</b></label>';
				echo '<input type="number" name="dalle" value=' . $fromHour . ' min="0" max="23" required><br>';
				echo '<label><b>Alle</b></label>';
				echo '<input type="number" name="alle" value=' . $toHour . ' min="0" max="23" required><br>';
				echo '<button type="submit">Prenota</button>';
			echo '</form> </div>';

			echo '<div id="PopUpModal" class="modal">';
			echo '<div class="modal-content">';
			echo '<span class="close" onClick="closePopUp()">&times;</span>';
			echo '<p id="errorText"></p>';
			echo '<p id="suggestions"></p>';
			echo '</div></div>';

			if (isset($_GET['errorMessage'])){				
				echo '<script> openPopUp();'; 
				echo 'document.getElementById("errorText").textContent = "' . $_GET['errorMessage'] .'";';
				echo 'showSuggestions("' . $_GET['suggestions'] .'");</script>';
			}		
		echo '</div>';

		echo '<div id="bottom">';
			echo '<section id="ReviewsDashboard"></section>';
		echo '</div>';
	echo '</div>';		
	}

//HISTORY
	function showBookings($result){
		$numBookings = mysqli_num_rows($result);
        if($numBookings <= 0){
			echo '<div class="ad">';
				echo '<h1>Non hai ancora effettuato nessuna prenotazione :(</h1>';
				echo '<h2>Effettuane subito una cliccando <a href="./prenota.php">QUI</a></h2>';
			echo '</div>';
            return $numBookings;
        }
		echo '<section id=Bookings class="container">';
		echo '<ul class="history_list">';
        while($bookingRow = $result->fetch_assoc()){ 
            echo '<li class="item_wrapper">';
            showBookingInfo($bookingRow);
            echo '</li>';
        }
        echo '</ul>';
        echo '</section>';
	}

	function showBookingInfo($bookingRow){
		echo '<div class="detail_booking_item">';
			echo '<h3>' . $bookingRow['nome'] . '</h3>';
			echo '<span>Data: ' . $bookingRow['dataP'] . '</span><br>';
			echo '<span>Orario: ' . $bookingRow['dalle'] . '</span><br><br>';
			echo '<a href="detailedField.php?fieldId=' . $bookingRow['fieldId'] .'"><i>Prenota di Nuovo</i></a>';
			
			$result2 = getReviewByUserIdFieldId($bookingRow['userId'], $bookingRow['fieldId']);
			$reviewed = mysqli_num_rows($result2);
			if(!$reviewed){	//max una recensione per campo 
				echo '<a href="valuta.php?fieldId='. $bookingRow['fieldId'] .'&idPrenotazione='. $bookingRow['idPrenotazione'] .'"><i>Valuta</i></a>';
			}
			echo '</div>';	
	}

	function showReviews($result){
		$numReviews = mysqli_num_rows($result);
        if($numReviews <= 0){
            return $numReviews;
        }
		echo '<section class="container Reviews">';
		echo '<ul class="history_list">';
        while($reviewRow = $result->fetch_assoc()){ 
            echo '<li class="item_wrapper">';
            showReviewInfo($reviewRow);
            echo '</li>';
        }
        echo '</ul>';
		echo '</section>';
	}

	function showReviewInfo($reviewRow){
		echo '<div class="detail_review_item">';
			$confirmMessage = "'Sei sicuro di voler eliminare questa recensione?'";  // gli apici ' servono per farlo leggere a JS
			echo '<h3>' . $reviewRow['nome'] . '</h3>';
			echo '<a class="closebtn" onclick="return confirm('. $confirmMessage . ')" href="deleteReview.php?id=' . $reviewRow['idReview'] .'">&times;</a><br>';
			echo '<h4><i>' . $reviewRow['reviewTitle'] . '</i></h4>';
			//Stelle
			for ($i = 0; $i < $reviewRow['rating']; $i++) {
				echo '<span class="rating_field_star checked"></span>';
			}
			while ($i < 5){
				echo '<span class="rating_field_star"></span>';
				$i++;
			}
			echo '<div class="text">';
				echo '<p>' . $reviewRow['review'] . '</p>';
			echo '</div>';
		echo '</div>';	
	}

//ADD YOUR FIELD
	function showAddYourFieldForm(){
		if($_SESSION['userType'] != 'socio'){
			echo '<div class="ad">';
				echo '<h1>Per aggiungere un campo a ScoreX devi essere socio</h1>';
				echo '<h1>Clicca <a href="./profile.php">QUI</a> per diventare socio</h1>';
			echo '</div>';
		}

		if($_SESSION['userType'] =='socio'){
			echo '<div id="add_your_field_form">';
				echo '<h1>Aggiungi Il Tuo Campo</h1>';

					//FORM CAMPO
/*per mandare img*/	echo '<form enctype="multipart/form-data" name="fieldForm" action="insertField.php" method="post" onSubmit="return checkField()">';
					
						echo '<label>Nome</label>';
						echo '<input type="text" placeholder="Inserisci Nome Campo" name="nome" required>';
						echo '<label>Descrizione</label>';
						echo '<input type="text" placeholder="Campo in erba sintetica..." name="descrizione">';

						echo' <div class="input_box">';
							echo '<label>Città</label><br>';
							echo '<input type="text" placeholder="" name="citta" required>';
							echo '<label>CAP</label><br>';
							echo '<input type="text" placeholder="" name="cap" required>';
						echo '</div>';

						echo '<div class="input_box right">';
							echo '<label>Indrizzo</label>';
							echo '<input type="text" placeholder="Via Example 10" name="indirizzo" required>';
							echo '<label>Telefono</label>';
							echo '<input type="text" placeholder="" name="telefono" required>';
						echo '</div><br>';

						echo '<label for="img">Select image:</label>';
						echo '<input type="file" id="img" name="img">';

					//FORM ORARIO
						echo '<h2 id="scheduleTag">Aggiungi Orario Settimanale</h2>';
						echo '<p>(N.B. lasciare incompleti gli orari dei giorni di riposo)</p>';
						$weekDays = ['Lunedì','Martedì', 'Mercoledì', 'Giovedì', 'Venerdì','Sabato','Domenica'];
						echo '<div class="schedule">';
							echo '<div class="scheduleDay">';
							echo '<label>Dalle:</label><br><br><br><br>';
							echo '<label>Alle:</label><br>';
							echo '</div>';
						for($x=0; $x<7; $x++){
							echo '<div class="scheduleDay">';
							echo '<label><b>'. $weekDays[$x] .'</b></label><br>';
							echo '<input type="number" name="dalle'.$x.'" min="0" max="23">';
							echo '<input type="number" name="alle'.$x.'" min="0" max="23"><br>';
							echo '</div>';
						}
						echo '</div>';
					echo '<button id="submitBtn" type="submit" name="submit" value="upload">Aggiungi il tuo campo</button>';
				echo '</form>';
			echo '</div>';

			echo '<div id="errorText"></div>';
			if (isset($_GET['errorMessage'])){				
				echo '<script> openPopUp();'; 
				echo 'document.getElementById("errorText").textContent = "' . $_GET['errorMessage'] .'";';
				echo '</script>';
			}		
		}
	}
?>