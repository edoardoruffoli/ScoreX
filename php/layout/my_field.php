<?php
    require_once "./util/fieldsManagerDb.php";
    require_once "./util/sessionUtil.php";
    require_once "./util/message_Util.php";

    function showMyField($result){
        $numFields = mysqli_num_rows($result);
		if($numFields < 1) { 
            echo '<div class="ad">';
                echo '<h1>Per aggiungere un campo a ScoreX clicca <a href="./addYourField.php">QUI</a> </h1>';
            echo '</div>';
			return;
		}
        while($fieldRow = $result->fetch_assoc()){
            echo '<div class="myFieldTab">';
                echo '<div class="top">';
                    echo '<h1><a href="../php/detailedField.php?fieldId=' . $fieldRow['fieldId'] . '">' . $fieldRow['nome'] . '</a></h1>';
                echo '</div>';
                echo '<div class="updateIcon" onClick="submitUpdateFieldForm('.$fieldRow['fieldId'].')"></div>';

                echo '<form class="updateForm" name="updateFieldForm'.$fieldRow['fieldId'].'" method="post" action="updateField.php">';
                    echo '<input name="fieldId" type="hidden" value="'. $fieldRow['fieldId'] . '">';
                    echo '<input name="nome" type="hidden" value="'. $fieldRow['nome'] . '">';
                    echo '<input name="descrizione" type="hidden" value="' . $fieldRow['descrizione'] . '">';
                    echo '<input name="telefono" type="hidden" value="' . $fieldRow['telefono'] . '">';
                    echo '<input name="img" type="hidden" value="' . $fieldRow['poster'] . '">';
                echo '</form>';

                echo '<div class="middle">';
                    echo '<div class="bookings_dashboard">';
                        $bookings = getNextBookingsByFieldId($fieldRow['fieldId']); 
                        $numBookings = mysqli_num_rows($bookings);
                        $confirmMessage = "'Sei sicuro?'";  
                        if($numFields < 1) { 
                            showError();	
                            return;
                        }

                        echo '<h2> Prenotazioni nei prossimi giorni</h2>';
                        echo '<table>';
                            echo '<tr>';
                                echo '<th>Giorno</th>';
                                echo '<th class="small">Orario</th>';
                                echo '<th>Utente</th>';
                                echo '<th>Telefono</th>';
                                echo '<th class="emptyCol"></th>';
                            echo '</tr>';
                        
                        while($bookingRow = $bookings->fetch_assoc()){
                            //Nome del giorno
                            $unixTimestamp = strtotime($bookingRow['dataP']);
                            $dayOfWeek = date("l", $unixTimestamp);
                            //controllo se la prenotazione è stata aggiunta dal proprietario del campo
                            if($bookingRow['username'] == $_SESSION['username']){
                                $bookingRow['username'] = 'ESTERNO';
                            }

                            echo '<tr>'; 
                                echo '<td>' . $bookingRow['dataP'] . ' ' . $dayOfWeek . '</td>';
                                echo '<td class="small">' . $bookingRow['dalle'] . '</td>';
                                echo '<td>' . $bookingRow['username'] . '</td>';
                                echo '<td>' . $bookingRow['telefono'] . '</td>';
                                echo '<td class="delete"><a href="../php/deleteBooking.php?id=' . $bookingRow['idPrenotazione'];
                                echo '"onclick="return confirm('. $confirmMessage . ')" >&#10060 Elimina</a></td>';
                            echo '</tr>';   
                        }
                        echo '</table>';
                    echo '</div>';

                //aggiungi una prenotazione esterna al sito//SIMILE A QUELLO IN DETAILED FIELD
                $month = date('m');
                $day = date('d');
                $year = date('Y');
                $fromHour = date('H');
                $toHour = ($fromHour+1==24)?0:$fromHour+1;
                $today = $year . '-' . $month . '-' . $day ;
                 
                    echo '<div class="right">';
                        echo '<div class="booking_form">';
                            echo '<form name="bookingForm" action="insertBooking.php?fieldId=' . $fieldRow['fieldId'] .'" method="post" onSubmit="return aggPrenotazione()">';
                                echo '<p><b>Aggiungi qui le prenotazioni ricevute telefonicamente</b></p>';
                                echo '<label><b>Giorno</b></label>';
                                echo '<input type="date" name="data" value=' . $today . ' min=' . $today . ' required><br>';
                                        
                                echo '<label><b>Dalle</b></label>';
                                echo '<input type="number" name="dalle" value=' . $fromHour . ' min="0" max="23" required><br>';
                                    
                                echo '<label><b>Alle</b></label>';
                                echo '<input type="number" name="alle" value=' . $toHour . ' min="0" max="23" required><br>';
                                
                                echo '<label><b>Telefono</b></label>';
                                echo '<input type="text" value="" name="telefono"><br>';
                                
                                echo '<button type="submit">Aggiungi una prenotazione</button>';
                            echo '</form>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }   

        echo '<div id="PopUpModal" class="modal">';
            echo '<div class="modal-content">';
                echo '<span class="close" onClick="closePopUp()">&times;</span>';
                echo '<p id="errorText"></p>';
                echo '</div>';
        echo '</div>';
    
        if (isset($_GET['errorMessage'])){				
            echo '<script> openPopUp();'; 
            echo 'document.getElementById("errorText").textContent = "' . $_GET['errorMessage'] .'";';
            echo '</script>';
        }		
    }
?>