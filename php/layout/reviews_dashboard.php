<?php
    require_once "./util/fieldsManagerDb.php";
    require_once "./util/sessionUtil.php";
    require_once "./util/message_Util.php";

    function showReviewForm(){
        if(isset($_GET['fieldId']) && isset($_GET['idPrenotazione'])){
            $result = getFieldById($_GET['fieldId']);
            $field = $result->fetch_assoc();
            echo '<div id="reviewForm">';  
                echo '<div id="top">';
                    echo '<h1>Valuta la tua esperienza</h1>';
                    echo '<h2>' . $field['nome'] .'</h2>';
                    echo '</div>';
                    echo '<form name="reviewForm" action="insertReview.php?fieldId='. $_GET['fieldId'] .'&idPrenotazione='. $_GET['idPrenotazione']. '" method="post" onSubmit="return checkReview()">';
                      echo' <div id="inputBox">';
                        echo '<label>Rating</label><br>';                
                            echo '<span id="star1" class="rating_field_star add-rate" onclick=rate(1)></span>';
                            echo '<span id="star2" class="rating_field_star add-rate" onclick=rate(2)></span>';
                            echo '<span id="star3" class="rating_field_star add-rate" onclick=rate(3)></span>';
                            echo '<span id="star4" class="rating_field_star add-rate" onclick=rate(4)></span>';
                            echo '<span id="star5" class="rating_field_star add-rate" onclick=rate(5)></span>';
                            echo '<input id="rating" type="hidden" name="rating" default="">';
                        echo '<br>';
                        echo '<label>Titolo</label><br>';
                        echo '<input type="text" placeholder="" name="reviewTitle" required><br>';
                        echo '<label>Descrizione</label><br><span id="charcount">250 caratteri rimanenti</span><br>';
                        echo '<textarea name="reviewText" onkeyup="charCountUpdate(this.value)" maxlength="250"></textarea><br>';
                        
                       echo '<button type="submit" name="submit" value="upload">Scrivi Recensione</button>'; 
                    echo '</div>';
                echo '</form>';
        }
    }
?>